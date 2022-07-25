<?php

namespace App\Http\Livewire;

use App\Helpers\MyFunction;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Review;
use Livewire\Component;

class Otomatis extends Component
{
    public $categories;

    public $selectedCategory;
    public $amount;

    public $success;
    public $restaurants;
    public $reviews;

    public $case_folding;
    public $tokenizing;
    public $filtering;
    public $stemming;

    public $words;
    public $termFrequency;
    public $inverseDocumentFrequency;
    public $tfidf;

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
        $this->restaurants = Restaurant::where('categories', 'like', '%'.$this->selectedCategory.'%')->pluck('name');
        $this->reviews = Review::whereIn('restaurant', $this->restaurants)->get()->take($this->amount);


        // ### Case Folding ###
        $this->case_folding = MyFunction::caseFolding($this->reviews);
        
        // ### Tokenizing ###
        $this->tokenizing = MyFunction::tokenizing($this->case_folding);

        // ### Filtering ###
        $this->filtering = MyFunction::filtering($this->tokenizing);

        // ### Stemming ###
        $this->stemming = MyFunction::stemming($this->filtering);

        // ### Get Words ###
        $this->words = MyFunction::getWords($this->stemming);

        // ### Term Frequency (TF) ###
        $this->termFrequency = MyFunction::tf($this->words, $this->stemming);

        // ### Inverse Document Frequency (IDF) ###
        $this->inverseDocumentFrequency = MyFunction::idf($this->termFrequency, $this->stemming);

        // ### TF-IDF ###
        $this->tfidf = MyFunction::tfidf($this->termFrequency, $this->inverseDocumentFrequency);

        $this->success = true;
    }

    public function render()
    {
        // $selectedCategory = 'jepang';
        // $jumlahData = 100;
        // $restaurants = Restaurant::where('categories', 'like', '%'.$selectedCategory.'%')->pluck('name');
        // $test = Review::whereIn('restaurant', $restaurants)->get()->take($jumlahData);
        // dd($restaurants, $test);
        return view('livewire.otomatis');
    }
}
