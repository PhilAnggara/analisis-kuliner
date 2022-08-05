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
        // ### Case Folding ###
        $this->case_folding = Str::lower($this->review);

        // ### Tokenizing ###
        $this->tokenizing = explode(' ', preg_replace("#[[:punct:]]#", "", $this->case_folding));

        // ### Filtering ###
        $stopwords = json_decode(file_get_contents(storage_path('/app/public/json/stopwords.json'), true));
        $this->filtering = array_diff($this->tokenizing,$stopwords);
        
        // ### Stemming ###
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
        $positif = Review::where('rating', '>', 4)->get()->take(300);   // 300 data positif
        $netral = Review::where('rating', '=', 4)->get()->take(300);    // 300 data netral
        $negatif = Review::where('rating', '<', 4)->get()->take(300);   // 300 data negatif

        $this->dataTraining = collect([
            'positif' => $positif,
            'netral' => $netral,
            'negatif' => $negatif,
        ]);

        $reviews = collect()->merge($positif)->merge($netral)->merge($negatif);     // menggabungkan semua data positif, netral, negatif
        
        $case_folding = MyFunction::caseFolding($reviews);
        $tokenizing = MyFunction::tokenizing($case_folding);
        $filtering = MyFunction::filtering($tokenizing);
        $stemming = MyFunction::stemming($filtering);

        $samples = MyFunction::implodeStemming($stemming);
        $samples[] = $input;    // menambahkan input user ke array $samples
        $labels = MyFunction::getClass($stemming)->toArray();   // mengambil label dari data training

        // Token Count Vectorizer
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($samples);
        $vectorizer->transform($samples);

        // Tf-idf Transformer
        $transformer = new TfIdfTransformer($samples);
        $transformer->transform($samples);

        // Support Vector Classification
        $training = collect($samples)->take($reviews->count())->toArray();  // mengambil data training selain input user
        $testing = last($samples);  // mengambil data testing yang berisi input user

        $result = MyFunction::svc($training, $labels, $testing);

        return $result;
    }

    public function render()
    {
        return view('livewire.manual');
    }
}
