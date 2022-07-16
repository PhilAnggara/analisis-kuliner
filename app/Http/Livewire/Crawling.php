<?php

namespace App\Http\Livewire;

use App\Models\Review;
use Goutte\Client;
use Livewire\Component;
use Illuminate\Support\Str;

class Crawling extends Component
{
    public $success;

    public $restaurants;
    public $reviews;
    public $amount = 20;

    public function getData()
    {
        Review::all()->each(function ($item) {
            $item->delete();
        });


        // Ubah Maximum execution time
        ini_set('max_execution_time', '120');
        $client = new Client();

        // Base URL untuk restaurant di Manado
        $baseUrl = 'https://www.tripadvisor.co.id/Restaurants-g297721-Manado_North_Sulawesi_Sulawesi.html';
        // Request ke Base Url
        $getRestaurant = $client->request('GET', $baseUrl);

        // Collection untuk menampung data restaurant
        $this->restaurants = collect();
        $getRestaurant->filter('.YHnoF')->each(function ($item) {

            // ##################################
            // Jumlah restaurant yang akan diambil
            // ##################################
            $amountOfRest = 4;

            // Mengambil data restaurant sesuai jumlah yang ditentukan
            if ($this->restaurants->count() < $amountOfRest) {
                $this->restaurants->push([
                    'name' => Str::after($item->filter('.RfBGI')->text(), '. '),
                    'url' => 'https://www.tripadvisor.co.id'.$item->filter('.Lwqic')->attr('href'),
                ]);
            } else {
                return false;
            }
        });

        // Collection untuk menampung data review
        $this->reviews = collect();

        // Loop untuk mengambil data review dari setiap restaurant
        foreach ($this->restaurants as $restaurant) {
            // URL untuk setiap restaurant
            $url = $restaurant['url'];
            $this->restName = $restaurant['name'];

            $nextPage = true;
            $or = 0;
    
            // Lakukan perulangan sampai next page bernilai false
            while ($nextPage) {
                // Jika bukan merupakan halaman pertama maka lakukan request dengan url untuk paginate
                if ($or != 0) {
                    $url = Str::replaceFirst('Reviews', 'Reviews-or'.$or, $url);
                }
    
                // Request ke URL
                $response = $client->request('GET', $url);
                // Mengambil alamat restaurant
                $response->filter('a.AYHFM')->each(function ($item, $key) {
                    if ($key == 1) {
                        $this->restAddress = $item->text();
                    }
                });
    
                // Mengambil data review
                $response->filter('div.reviewSelector')->each(function ($item, $key) {
                    if (count($item->filter('.bubble_10'))) {
                        $rating = 1;
                    } elseif (count($item->filter('.bubble_20'))) {
                        $rating = 2;
                    } elseif (count($item->filter('.bubble_30'))) {
                        $rating = 3;
                    } elseif (count($item->filter('.bubble_40'))) {
                        $rating = 4;
                    } elseif (count($item->filter('.bubble_50'))) {
                        $rating = 5;
                    } else {
                        $rating = 0;
                    }
                    // Tampung data review ke review collection
                    $this->reviews->push([
                        // 'img_src' => $item->filter('img')->attr('src'),
                        'name' => $item->filter('.info_text ')->text(),
                        'date' => Str::after($item->filter('.prw_reviews_stay_date_hsx ')->text(), 'Tanggal kunjungan: '),
                        'restaurant' => $this->restName,
                        'address' => $this->restAddress,
                        'rating' => $rating,
                        'quote' => $item->filter('.quote ')->text(),
                        'review' => $item->filter('.prw_reviews_text_summary_hsx ')->text(),
                    ]);
                    Review::create([
                        'name' => $item->filter('.info_text ')->text(),
                        'date' => Str::after($item->filter('.prw_reviews_stay_date_hsx ')->text(), 'Tanggal kunjungan: '),
                        'restaurant' => $this->restName,
                        'address' => $this->restAddress,
                        'rating' => $rating,
                        'quote' => $item->filter('.quote ')->text(),
                        'review' => $item->filter('.prw_reviews_text_summary_hsx ')->text(),
                    ]);
                });
    
                // Cek apakah masih ada next page atau tidak
                if (!count($response->filter('a.next.ui_button.primary.disabled'))) {
                    $nextPage = true;
                    // Increment url paginate
                    $or += 10;
                } else {
                    $nextPage = false;
                }

                // ##############
                // Paksa berhenti
                // ##############
                if ($this->reviews->count() >= $this->amount) {
                    $nextPage = false;
                }
    
            }
            
            if ($this->reviews->count() >= $this->amount) {
                break;
            }
            
        }
        
        // Filter data review
        $filter_result = collect();
        foreach ($this->reviews as $review) {
            if ($review['date'] == 'Februari 2016') {
                $filter_result->push($review);
            }
        }

        $this->success = true;
        $this->emit('loadTable');
    }

    public function render()
    {
        return view('livewire.crawling');
    }
}
