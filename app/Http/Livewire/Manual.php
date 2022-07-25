<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Helpers\MyFunction;
use Illuminate\Support\Str;
use Sastrawi\Stemmer\StemmerFactory;

class Manual extends Component
{
    public $review;
    public $success;

    public $case_folding;
    public $tokenizing;
    public $filtering;
    public $stemming;

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

        // dd($this->review, $this->case_folding, $this->tokenizing, $this->filtering, $this->stemming);

        $this->success = true;
    }

    public function render()
    {
        return view('livewire.manual');
    }
}
