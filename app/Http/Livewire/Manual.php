<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Helpers\MyFunction;
use App\Models\Review;
use Illuminate\Support\Str;
use Phpml\Classification\SVC;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Tokenization\WhitespaceTokenizer;
use Sastrawi\Stemmer\StemmerFactory;

class Manual extends Component
{
    public $review;
    public $success;

    public $case_folding;
    public $tokenizing;
    public $filtering;
    public $stemming;

    public $dataTraining;
    public $result;

    public function mount()
    {
        $this->success = false;
    }

    public function process()
    {
        $this->case_folding = Str::lower($this->review);

        $this->tokenizing = explode(' ', preg_replace("#[[:punct:]]#", "", $this->case_folding));

        $stopwords = json_decode(file_get_contents(storage_path('/app/public/json/stopwords.json'), true));
        $this->filtering = array_diff($this->tokenizing,$stopwords);
        
        $stemmerFactory = new StemmerFactory();
        $stemmer = $stemmerFactory->createStemmer();
        $sentence = implode(' ', $this->filtering);
        $output   = $stemmer->stem($sentence);
        $this->stemming = explode(' ', $output);

        $this->result = $this->svm($output);

        $this->success = true;
    }

    public function svm($input)
    {
        $positif = Review::where('rating', '>', 3)->get()->take(300);
        $netral = Review::where('rating', '=', 3)->get()->take(300);
        $negatif = Review::where('rating', '<', 3)->get()->take(300);

        $this->dataTraining = collect([
            'positif' => $positif,
            'netral' => $netral,
            'negatif' => $negatif,
        ]);

        $reviews = collect();
        $positif = $positif->each(function ($item) use ($reviews) {
            $reviews->push($item);
        });
        $netral = $netral->each(function ($item) use ($reviews) {
            $reviews->push($item);
        });
        $negatif = $negatif->each(function ($item) use ($reviews) {
            $reviews->push($item);
        });
        
        $case_folding = MyFunction::caseFolding($reviews);
        $tokenizing = MyFunction::tokenizing($case_folding);
        $filtering = MyFunction::filtering($tokenizing);
        $stemming = MyFunction::stemming($filtering);

        $samples = [];
        foreach ($stemming as $item) {
            $sentence = implode(' ', $item['review']);
            $samples[] = $sentence;
        }
        $samples[] = $input;
        $labels = MyFunction::getClass($stemming)->toArray();

        // Token Count Vectorizer
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($samples);
        $vectorizer->transform($samples);

        // Tf-idf Transformer
        $transformer = new TfIdfTransformer($samples);
        $transformer->transform($samples);

        // Support Vector Classification
        $training = collect($samples)->take($reviews->count())->toArray();
        $testing = last($samples);

        $classifier = new SVC(Kernel::LINEAR, $cost = 1000);
        $classifier->train($training, $labels);

        $result = $classifier->predict($testing);

        return $result;
    }

    public function render()
    {
        return view('livewire.manual');
    }
}
