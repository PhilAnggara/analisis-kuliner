<?php

namespace App\Http\Livewire;

use App\Helpers\MyFunction;
use App\Helpers\TestingFunction;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Review;
use Livewire\Component;
use Phpml\Classification\SVC;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Tokenization\WhitespaceTokenizer;

class Otomatis extends Component
{
    public $categories;

    public $selectedCategory;
    public $amount;

    public $case_folding;
    public $tokenizing;
    public $filtering;
    public $stemming;

    public $success;

    public function mount()
    {
        $this->categories = Category::all();
        $this->selectedCategory = '';
        $this->amount = '';
        $this->success = false;

        $this->case_folding = collect();
        $this->tokenizing = collect();
        $this->filtering = collect();
        $this->stemming = collect();
    }

    public function process()
    {
        $restaurants = Restaurant::where('categories', 'like', '%'.$this->selectedCategory.'%')->pluck('name');
        $this->reviews = Review::whereIn('restaurant', $restaurants)->get()->shuffle()->take($this->amount);

        $this->case_folding = MyFunction::caseFolding($this->reviews);
        $this->tokenizing = MyFunction::tokenizing($this->case_folding);
        $this->filtering = MyFunction::filtering($this->tokenizing);
        $this->stemming = MyFunction::stemming($this->filtering);

        $reviews = [];  // array untuk menyimpan data training
        foreach ($this->stemming as $item) {
            $sentence = implode(' ', $item['review']);
            $reviews[] = $sentence;
        }
        $this->result = $this->svm($reviews);

        $positifCount = 0;
        $netralCount = 0;
        $negatifCount = 0;
        foreach ($this->result as $item) {
            if ($item > 0) {
                $positifCount++;
            } elseif ($item == 0) {
                $netralCount++;
            } else {
                $negatifCount++;
            }
        }
        $percentage = [
            // 'positif' => $positifCount / count($this->result) * 100,
            // 'netral' => $netralCount / count($this->result) * 100,
            // 'negatif' => $negatifCount / count($this->result) * 100,
            'positif' => $positifCount,
            'netral' => $netralCount,
            'negatif' => $negatifCount
        ];
        $this->emit('loadChart', $percentage);


        $this->success = true;
    }

    public function svm($reviews)
    {
        $positif = Review::where('rating', '>', 4)->get()->take(300);   // 300 data positif
        $netral = Review::where('rating', '=', 4)->get()->take(300);    // 300 data netral
        $negatif = Review::where('rating', '<', 4)->get()->take(300);   // 300 data negatif
        $dataTraining = collect()->merge($positif)->merge($netral)->merge($negatif);     // menggabungkan semua data positif, netral, negatif
        
        $case_folding = MyFunction::caseFolding($dataTraining);
        $tokenizing = MyFunction::tokenizing($case_folding);
        $filtering = MyFunction::filtering($tokenizing);
        $stemming = MyFunction::stemming($filtering);

        $samples = [];  // array untuk menyimpan data training
        foreach ($stemming as $item) {
            $sentence = implode(' ', $item['review']);  // menggabungkan review menjadi satu string
            $samples[] = $sentence;     // menambahkan string ke array $samples
        }
        foreach ($reviews as $item) {
            $samples[] = $item;    // menambahkan review ke array $samples
        }
        $labels = MyFunction::getClass($stemming)->toArray();   // mengambil label dari data training

        // Token Count Vectorizer
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($samples);
        $vectorizer->transform($samples);

        // Tf-idf Transformer
        $transformer = new TfIdfTransformer($samples);
        $transformer->transform($samples);

        // Support Vector Classification
        $training = collect($samples)->take($dataTraining->count())->toArray();  // mengambil data training selain input user
        $testing = array_values(collect($samples)->skip($dataTraining->count())->toArray());  // mengambil data testing

        $classifier = new SVC(Kernel::LINEAR, $cost = 1000);
        $classifier->train($training, $labels);     // training data

        $result = $classifier->predict($testing);   // menghitung prediksi data

        return $result;
    }

    public function render()
    {
        return view('livewire.otomatis');
    }
}
