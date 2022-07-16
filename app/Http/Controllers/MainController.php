<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Goutte\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function crawling()
    {
        return view('pages.crawling');
    }

    private $restaurant;
    public function scraping()
    {
        Restaurant::all()->each(function ($item) {
            $item->delete();
        });

        
        $this->restaurants = collect();
        $client = new Client();
        $url = 'https://www.tripadvisor.co.id/Restaurants-g297721-Manado_North_Sulawesi_Sulawesi.html';
        $getRestaurant = $client->request('GET', $url);

        $getRestaurant->filter('.YHnoF')->each(function ($item, $key) {
            $this->restaurants->push([
                'no' => $key+1,
                'name' => Str::after($item->filter('.RfBGI')->text(), '. '),
                'katgori' => explode(', ', $item->filter('.nrKLE.PQvPS.bAdrM > .qAvoV')->text()),
                'url' => 'https://www.tripadvisor.co.id'.$item->filter('.Lwqic')->attr('href'),
            ]);
            Restaurant::create([
                'name' => Str::after($item->filter('.RfBGI')->text(), '. '),
                'katgori' => $item->filter('.nrKLE.PQvPS.bAdrM > .qAvoV')->text(),
                'url' => 'https://www.tripadvisor.co.id'.$item->filter('.Lwqic')->attr('href'),
            ]);
        });
        return response()->json($this->restaurants);
    }

    public function preprocessing()
    {
        return view('pages.preprocessing');
    }
}
