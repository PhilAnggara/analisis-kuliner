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

    public $words;
    public $termFrequency;
    public $inverseDocumentFrequency;
    public $tfidf;

    public function mount()
    {
        $this->success = false;
        $this->reviews = Review::all()->take(50);
        $this->stopwords = json_decode(file_get_contents(storage_path('/app/public/json/stopwords.json'), true));

        $this->case_folding = collect();
        $this->tokenizing = collect();
        $this->filtering = collect();
        $this->stemming = collect();
    }

    public function process()
    {
        // ### Case Folding ###
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
        
        // ### Tokenizing ###
        foreach ($this->case_folding as $item) {

            $item['quote'] = preg_replace("#[[:punct:]]#", "", $item['quote']);     // hapus tanda baca (., ?, !, :, ;, -, _, etc)
            $item['review'] = preg_replace("#[[:punct:]]#", "", $item['review']);   // hapus tanda baca (., ?, !, :, ;, -, _, etc)
            
            $this->tokenizing->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => explode(' ', $item['review']),  // pisahkan setiap kata dari review menjadi array
            ]);
        }

        // ### Filtering ###
        foreach ($this->tokenizing as $item) {

            $item['review'] = array_diff($item['review'],$this->stopwords);     // hapus kata yang ada di stopwords.json (daftar kata yang tidak memiliki makna)

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

        // ### Stemming ###
        foreach ($this->filtering as $item) {

            $stemmerFactory = new StemmerFactory();     // inisialisasi StemmerFactory
            $stemmer = $stemmerFactory->createStemmer();    // inisialisasi Stemmer

            $sentence = implode(' ', $item['review']);   // gabungkan setiap kata dari review menjadi satu string
            $output   = $stemmer->stem($sentence);  // ubah setiap kata menjadi kata dasar (stemming)

            $this->stemming->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => explode(' ', $output),  // pisahkan kembali setiap kata hasil stemming menjadi array
            ]);
        }

        $words = collect();     // buat variable untk menampung daftar kata
        foreach ($this->stemming as $stm) {     // lopping semua data yang sudah di stemming
            foreach ($stm['review'] as $s) {    // looping semua kata dari setiap review
                if (!$words->contains($s)) {    // jika kata tidak ada di daftar kata, maka tambahkan
                    $words->push($s);
                }
            }
        }
        $this->words = $words;

        // ### Term Frequency (TF) ###
        $tf = collect();    // buat variable untk menampung data term frequency
        foreach ($words as $word) {     // looping semua data words
            $d = collect();     // buat variable untuk menampung term frequency dari setiap kata
            foreach ($this->stemming as $stm) {     // looping semua data yang sudah di stemming
                $i = 0;
                foreach ($stm['review'] as $s) {
                    if ($word == $s) {  // jika kata sama dengan kata yang di looping, maka tambahkan 1 ke variabel i
                        $i++;
                    }
                }
                $d->push($i);   // push i ke d
            }
            $tf->push([
                'kata' => $word,
                'data' => $d,
            ]);
        }
        $this->termFrequency = $tf;

        // ### Inverse Document Frequency (IDF) ###
        $idf = collect();   // buat variable untk menampung data inverse document frequency (idf)
        foreach ($tf as $item) {    // looping semua data term frequency (tf)
            $idf->push([    // push data term frequency (tf) ke inverse document frequency (idf)
                'kata' => $item['kata'],
                'df' => array_sum($item['data']->toArray()),
                'idf' => log(count($this->stemming) / array_sum($item['data']->toArray())),     // idf = log(N/df)
            ]);
        }
        $this->inverseDocumentFrequency = $idf;

        // ### TF-IDF ###
        $tfidf = collect();     // buat variable untk menampung data tf-idf
        $loopIndex = 0;     // buat variable untk penanda index looping yang akan digunakan untuk mengalikan tf dan idf dengan index tersebut
        foreach ($tf as $item) {    // looping semua data term frequency (tf)
            $tempData = collect();  // buat variable untk menampung data sementara tf-idf dari setiap kata
            foreach ($item['data'] as $data) {  // looping semua data term frequency (tf) dari setiap kata
                $tempData->push($data * $idf[$loopIndex]['idf']);   // tf-idf = tf * idf
            }
            $tfidf->push([  // push data hasil tf-idf ke variabel tfidf
                'kata' => $item['kata'],
                'data' => $tempData
            ]);
            $loopIndex++;
        }
        $this->tfidf = $tfidf;

        $this->success = true;
    }

    public function render()
    {
        return view('livewire.preprocessing');
    }
}
