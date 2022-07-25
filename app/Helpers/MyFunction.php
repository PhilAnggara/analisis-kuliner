<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Sastrawi\Stemmer\StemmerFactory;

class MyFunction
{
    public static function caseFolding($reviews)
    {
        $result = collect();
        foreach ($reviews as $item) {
            $result->push([
                'name' => $item->name,
                'date' => $item->date,
                'restaurant' => $item->restaurant,
                'address' => $item->address,
                'rating' => $item->rating,
                'quote' => Str::lower($item->quote),
                'review' => Str::lower($item->review),
            ]);
        }

        return $result;
    }

    public static function tokenizing($caseFolding)
    {
        $result = collect();
        foreach ($caseFolding as $item) {

            $item['quote'] = preg_replace("#[[:punct:]]#", "", $item['quote']);     // hapus tanda baca (., ?, !, :, ;, -, _, etc)
            $item['review'] = preg_replace("#[[:punct:]]#", "", $item['review']);   // hapus tanda baca (., ?, !, :, ;, -, _, etc)
            
            $result->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => explode(' ', $item['review']),  // pisahkan setiap kata dari review menjadi array
            ]);
        }

        return $result;
    }

    public static function filtering($tokenizing)
    {
        $stopwords = json_decode(file_get_contents(storage_path('/app/public/json/stopwords.json'), true));
        $result = collect();
        foreach ($tokenizing as $item) {

            $item['review'] = array_diff($item['review'],$stopwords);     // hapus kata yang ada di stopwords.json (daftar kata yang tidak memiliki makna)

            $result->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => $item['review'],
            ]);
        }

        return $result;
    }

    public static function stemming($filtering)
    {
        $result = collect();
        foreach ($filtering as $item) {
            
            $stemmerFactory = new StemmerFactory();     // inisialisasi StemmerFactory
            $stemmer = $stemmerFactory->createStemmer();    // inisialisasi Stemmer

            $sentence = implode(' ', $item['review']);   // gabungkan setiap kata dari review menjadi satu string
            $output   = $stemmer->stem($sentence);  // ubah setiap kata menjadi kata dasar (stemming)

            $result->push([
                'name' => $item['name'],
                'date' => $item['date'],
                'restaurant' => $item['restaurant'],
                'address' => $item['address'],
                'rating' => $item['rating'],
                'quote' => $item['quote'],
                'review' => explode(' ', $output),  // pisahkan kembali setiap kata hasil stemming menjadi array
            ]);
            
        }

        return $result;
    }

    public static function getWords($stemming)
    {
        $result = collect();     // buat variable untk menampung daftar kata
        foreach ($stemming as $item) {     // lopping semua data yang sudah di stemming
            foreach ($item['review'] as $s) {    // looping semua kata dari setiap review
                if (!$result->contains($s)) {    // jika kata tidak ada di daftar kata, maka tambahkan
                    $result->push($s);
                }
            }
        }

        return $result;
    }

    public static function tf($words, $stemming)
    {
        $result = collect();    // buat variable untk menampung data term frequency
        foreach ($words as $word) {     // looping semua data words
            $d = collect();     // buat variable untuk menampung term frequency dari setiap kata
            foreach ($stemming as $stm) {     // looping semua data yang sudah di stemming
                $i = 0;
                foreach ($stm['review'] as $s) {
                    if ($word == $s) {  // jika kata sama dengan kata yang di looping, maka tambahkan 1 ke variabel i
                        $i++;
                    }
                }
                $d->push($i);   // push i ke d
            }
            $result->push([
                'kata' => $word,
                'data' => $d,
            ]);
        }

        return $result;
    }

    public static function idf($tf, $stemming)
    {
        $result = collect();   // buat variable untk menampung data inverse document frequency (idf)
        foreach ($tf as $item) {    // looping semua data term frequency (tf)
            $result->push([    // push data term frequency (tf) ke inverse document frequency (idf)
                'kata' => $item['kata'],
                'df' => array_sum($item['data']->toArray()),
                'idf' => log(count($stemming) / array_sum($item['data']->toArray())),     // idf = log(N/df)
            ]);
        }

        return $result;
    }

    public static function tfidf($tf, $idf)
    {
        $result = collect();     // buat variable untk menampung data tf-idf
        $loopIndex = 0;     // buat variable untk penanda index looping yang akan digunakan untuk mengalikan tf dan idf dengan index tersebut
        foreach ($tf as $item) {    // looping semua data term frequency (tf)
            $tempData = collect();  // buat variable untk menampung data sementara tf-idf dari setiap kata
            foreach ($item['data'] as $data) {  // looping semua data term frequency (tf) dari setiap kata
                $tempData->push($data * $idf[$loopIndex]['idf']);   // tf-idf = tf * idf
            }
            $result->push([  // push data hasil tf-idf ke variabel tfidf
                'kata' => $item['kata'],
                'data' => $tempData
            ]);
            $loopIndex++;
        }

        return $result;
    }
}
