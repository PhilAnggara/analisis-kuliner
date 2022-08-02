<?php

namespace App\Http\Livewire;

use App\Helpers\MyFunction;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Review;
use Livewire\Component;
use Phpml\Classification\SVC;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Metric\Accuracy;
use Phpml\Metric\ClassificationReport;
use Phpml\Metric\ConfusionMatrix;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Tokenization\WhitespaceTokenizer;

class Multiple extends Component
{
    public $categories;

    public $selectedCategory;
    public $amount;
    public $partisi;

    public $reviews;
    public $dataTesting;

    public $case_folding;
    public $tokenizing;
    public $filtering;
    public $stemming;

    public $words;
    public $termFrequency;
    public $inverseDocumentFrequency;
    public $tfidf;
    public $kernel;
    public $hessian;

    public $result;
    public $report;
    public $confusionMatrix;

    public $success;

    public function mount()
    {
        $this->categories = Category::all();
        $this->selectedCategory = '';
        $this->amount = 200;
        $this->partisi = '';
        $this->success = false;

        $this->dataTesting = collect();

        $this->case_folding = collect();
        $this->tokenizing = collect();
        $this->filtering = collect();
        $this->stemming = collect();
    }

    public function process()
    {
        $rerstaurant = Restaurant::where('categories', 'like', '%'.$this->selectedCategory.'%')->pluck('name');
        $positif = Review::whereIn('restaurant', $rerstaurant)->where('rating', '>', 4)->get()->take(round(34 / 100 * $this->amount));
        $netral = Review::whereIn('restaurant', $rerstaurant)->where('rating', '=', 4)->get()->take(round(33 / 100 * $this->amount));
        $negatif = Review::whereIn('restaurant', $rerstaurant)->where('rating', '<', 4)->get()->take(round(33 / 100 * $this->amount));
        $this->reviews = collect()->merge($positif)->merge($netral)->merge($negatif)->shuffle();

        $trainAmount = round($this->partisi / 100 * $this->reviews->count());  // jumlah data training

        $i = 1;
        foreach ($this->reviews as $review) {
            if ($i > $trainAmount) {
                $this->dataTesting->push($review);
            }
            $i++;
        }


        $this->case_folding = MyFunction::caseFolding($this->reviews);
        $this->tokenizing = MyFunction::tokenizing($this->case_folding);
        $this->filtering = MyFunction::filtering($this->tokenizing);
        $this->stemming = MyFunction::stemming($this->filtering);
        $this->words = MyFunction::getWords($this->stemming);
        $this->termFrequency = MyFunction::tf($this->words, $this->stemming);
        $this->inverseDocumentFrequency = MyFunction::idf($this->termFrequency, $this->stemming);
        $this->tfidf = MyFunction::tfidf($this->termFrequency, $this->inverseDocumentFrequency);
        $this->kernel = MyFunction::kernel($this->tfidf, MyFunction::getClass($this->stemming));
        $this->hessian = MyFunction::hessian($this->kernel);
        $this->error = MyFunction::error($this->hessian);
        $this->delta = MyFunction::delta($this->error);
        $this->alpha = MyFunction::alpha($this->delta);


        $samples = [];  // array untuk menyimpan data training
        foreach ($this->stemming as $item) {
            $sentence = implode(' ', $item['review']);  // menggabungkan review menjadi satu string
            $samples[] = $sentence;     // menambahkan string ke array $samples
        }
        $labels = MyFunction::getClass($this->stemming)->toArray();   // mengambil label dari data training

        // Token Count Vectorizer
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($samples);
        $vectorizer->transform($samples);

        // Tf-idf Transformer
        $transformer = new TfIdfTransformer($samples);
        $transformer->transform($samples);

        // Support Vector Classification
        $training = collect($samples)->take($this->reviews->count() - 5)->toArray();   // memisahkan data training
        $testing = array_values(collect($samples)->skip($trainAmount)->toArray());    // memisahkan data testing
        $labels = collect($labels)->take($this->reviews->count() - 5)->toArray();      // memisahkan label training

        $classifier = new SVC(Kernel::LINEAR, $cost = 1000);
        $classifier->train($training, $labels);     // training data

        $this->result = $classifier->predict($testing);   // menghitung prediksi data

        $actualLabels = MyFunction::getClass($this->stemming->skip($trainAmount))->toArray();   // mengambil label dari data testing
        $predictedLabels = $this->result;

        $accuracy = ['accuracy' => Accuracy::score($actualLabels, $predictedLabels)];;
        $report = new ClassificationReport($actualLabels, $predictedLabels);
        $report = $report->getAverage();
        $this->report = array_merge($accuracy, $report);

        $this->confusionMatrix = ConfusionMatrix::compute($actualLabels, $predictedLabels, [1, 0, -1]);

        $this->success = true;
        $this->emit('loadChart', $this->report);
    }

    public function render()
    {
        return view('livewire.multiple');
    }
}
