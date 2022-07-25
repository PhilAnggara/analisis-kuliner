<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Goutte\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function dataTraining()
    {
        $items = Review::all();
        return view('pages.data-training', [
            'items' => $items,
        ]);
    }

    public function manual()
    {
        return view('pages.manual');
    }

    public function otomatis()
    {
        return view('pages.otomatis');
    }

    public function multiple()
    {
        return view('pages.multiple');
    }



    
    public function crawling()
    {
        return view('pages.crawling');
    }
 
    public function scraping()
    {
        // return response()->json($this->scraper());
        // return response()->json($this->getReviews());
    }

    public function preprocessing()
    {
        return view('pages.preprocessing');
    }
}
