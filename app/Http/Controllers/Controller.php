<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\Review;
use Goutte\Client;
use Illuminate\Support\Str;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function scraper()
    {
        Restaurant::all()->each(function ($item) {
            $item->delete();
        });
        Category::all()->each(function ($item) {
            $item->delete();
        });
        $this->restaurants = collect();

        $client = new Client();
        $url = 'https://www.tripadvisor.co.id/Restaurants-g297721-Manado_North_Sulawesi_Sulawesi.html';

        $nextPage = true;
        $oa = 0;

        while ($nextPage) {

            if ($oa != 0) {
                $url = Str::replaceFirst('g297721', 'g297721-oa'.$oa, $url);
            }
            $getRestaurant = $client->request('GET', $url);
            
            $getRestaurant->filter('.YHnoF')->each(function ($item, $key) {
                if ($item->filter('.nrKLE.PQvPS.bAdrM > .qAvoV')->count() && !Str::startsWith($item->filter('.nrKLE.PQvPS.bAdrM > .qAvoV')->text(), '$')) {
                    $kat = $item->filter('.nrKLE.PQvPS.bAdrM > .qAvoV')->text();
                } else {
                    $kat = null;
                }
                $this->restaurants->push([
                    'no' => Str::before($item->filter('.RfBGI')->text(), '.'),
                    'name' => Str::after($item->filter('.RfBGI')->text(), '. '),
                    'categories' => explode(', ', $kat),
                    'url' => 'https://www.tripadvisor.co.id'.$item->filter('.Lwqic')->attr('href'),
                ]);
                Restaurant::create([
                    'no' => Str::before($item->filter('.RfBGI')->text(), '.'),
                    'name' => Str::after($item->filter('.RfBGI')->text(), '. '),
                    'categories' => $kat,
                    'url' => 'https://www.tripadvisor.co.id'.$item->filter('.Lwqic')->attr('href'),
                ]);
            });
            
            if (!count($getRestaurant->filter('span.next.disabled'))) {
                $nextPage = true;
                $oa += 30;
            } else {
                $nextPage = false;
            }

        }

        $categories = collect();    // collection untuk menampung data kategori
        foreach ($this->restaurants as $restaurant) {
            foreach ($restaurant['categories'] as $cat) {
                if (!$categories->contains($cat)) {
                    $categories->push($cat);
                }
            }
        }
        // remove kategori kosong
        $categories = $categories->filter(function ($item) {
            return $item != null;
        })->values();
        $categories = $categories->each(function ($item) {
            Category::create([
                'name' => $item,
            ]);
        });

        return [
            'categories' => $categories,
            'restaurants' => $this->restaurants,
        ];
    }









    public function getReviews()
    {
        ini_set('max_execution_time', '1800');  // set max execution time to 30 minutes

        
        $restaurants = Restaurant::all();   // ambil semua data restaurant dari database
        Review::all()->each(function ($item) {
            $item->delete();    // hapus semua data review dari database
        });
        $this->reviews = collect();     // collection untuk menampung data review
        $this->limit = 50000;   // limit review yang akan diambil

        $client = new Client();     // inisialisasi client untuk scraping

        foreach ($restaurants as $restaurant) {     // looping sebanyak data restaurant yang ada
            $url = $restaurant->url;    // ambil url restaurant yang akan diambil reviewnya
            $this->restName = $restaurant->name;    // ambil nama restaurant yang akan diambil reviewnya

            $nextPage = true;   // boolean untuk menentukan apakah ada halaman selanjutnya atau tidak
            $or = 0;    // variabel untuk menentukan halaman yang akan diambil reviewnya
    
            while ($nextPage) {     // Lakukan perulangan sampai next page bernilai false
                if ($or != 0) {     // jika bukan merupakan halaman pertama maka lakukan request dengan url untuk paginate
                    $url = Str::replaceFirst('Reviews', 'Reviews-or'.$or, $url);    // ganti url dengan url yang baru
                }
    
                $response = $client->request('GET', $url);   // request ke url
                $response->filter('a.AYHFM')->each(function ($item, $key) {
                    if ($key == 1) {
                        $this->restAddress = $item->text();     // ambil alamat restaurant
                    }
                });
    
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

                    if ($this->reviews->count() < $this->limit) {
                        $this->reviews->push([  // tambahkan data review ke collection
                            'name' => $item->filter('.info_text ')->text(),
                            'date' => Str::after($item->filter('.prw_reviews_stay_date_hsx ')->text(), 'Tanggal kunjungan: '),
                            'restaurant' => $this->restName,
                            'address' => $this->restAddress,
                            'rating' => $rating,
                            'quote' => $item->filter('.quote ')->text(),
                            'review' => $item->filter('.prw_reviews_text_summary_hsx ')->text(),
                        ]);
                        Review::create([    // simpan data review ke database
                            'name' => $item->filter('.info_text ')->text(),
                            'date' => Str::after($item->filter('.prw_reviews_stay_date_hsx ')->text(), 'Tanggal kunjungan: '),
                            'restaurant' => $this->restName,
                            'address' => $this->restAddress,
                            'rating' => $rating,
                            'quote' => $item->filter('.quote ')->text(),
                            'review' => $item->filter('.prw_reviews_text_summary_hsx ')->text(),
                        ]);
                    }
                    // $this->reviews->push([  // tambahkan data review ke collection
                    //     'name' => $item->filter('.info_text ')->text(),
                    //     'date' => Str::after($item->filter('.prw_reviews_stay_date_hsx ')->text(), 'Tanggal kunjungan: '),
                    //     'restaurant' => $this->restName,
                    //     'address' => $this->restAddress,
                    //     'rating' => $rating,
                    //     'quote' => $item->filter('.quote ')->text(),
                    //     'review' => $item->filter('.prw_reviews_text_summary_hsx ')->text(),
                    // ]);
                    // Review::create([    // simpan data review ke database
                    //     'name' => $item->filter('.info_text ')->text(),
                    //     'date' => Str::after($item->filter('.prw_reviews_stay_date_hsx ')->text(), 'Tanggal kunjungan: '),
                    //     'restaurant' => $this->restName,
                    //     'address' => $this->restAddress,
                    //     'rating' => $rating,
                    //     'quote' => $item->filter('.quote ')->text(),
                    //     'review' => $item->filter('.prw_reviews_text_summary_hsx ')->text(),
                    // ]);
                });

                if (!count($response->filter('a.next.ui_button.primary.disabled')) && count($response->filter('a.pageNum.first'))) {   // jika tidak ada halaman selanjutnya
                    $nextPage = true;
                    $or += 10;
                } else {
                    $nextPage = false;
                }

                if ($this->reviews->count() >= $this->limit) {
                    $nextPage = false;
                }
    
            }
            
            if ($this->reviews->count() >= $this->limit) {
                break;
            }
        }

        return $this->reviews;
    }
}
