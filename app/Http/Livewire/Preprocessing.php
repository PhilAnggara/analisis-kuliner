<?php

namespace App\Http\Livewire;

use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Sastrawi\Stemmer\StemmerFactory;

class Preprocessing extends Component
{
    public $success;
    public $reviews;
    public $stopwords;

    public $case_folding;
    public $tokenizing;
    public $filtering;
    public $stemming;

    public function mount()
    {
        $this->success = false;
        $this->reviews = Review::all();
        $this->stopwords = json_decode(file_get_contents(storage_path('/app/public/json/stopwords.json'), true));

        $this->case_folding = collect();
        $this->tokenizing = collect();
        $this->filtering = collect();
        $this->stemming = collect();
    }

    public function process()
    {
        // Case Folding
        foreach ($this->reviews as $item) {

            $this->case_folding->push([
                'name' => $item->name,
                'date' => $item->date,
                'restaurant' => $item->restaurant,
                'address' => $item->address,
                'rating' => $item->rating,
                'quote' => Str::lower($item->quote),
                'review' => Str::lower($item->review),
            ]);
        }
        
        // Tokenizing
        foreach ($this->case_folding as $item) {

            $item['quote'] = preg_replace("#[[:punct:]]#", "", $item['quote']);
            $item['review'] = preg_replace("#[[:punct:]]#", "", $item['review']);
            
            $this->tokenizing->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => explode(' ', $item['review']),
            ]);
        }

        // Filtering
        foreach ($this->tokenizing as $item) {

            $item['review'] = array_diff($item['review'],$this->stopwords);

            $this->filtering->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => $item['review'],
            ]);
        }

        // Stemming
        foreach ($this->filtering as $item) {

            $stemmerFactory = new StemmerFactory();
            $stemmer = $stemmerFactory->createStemmer();

            $sentence = implode(' ', $item['review']);
            $output   = $stemmer->stem($sentence);

            $this->stemming->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => explode(' ', $output),
            ]);
        }

        $this->success = true;
    }

    public function render()
    {
        return view('livewire.preprocessing');
    }
}
