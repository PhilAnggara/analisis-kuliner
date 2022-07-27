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
        // // Kernel
        // $d1 = (0.079181 * 0.079181) + (-0.06695 * -0.06695);
        // dd($d1);


        // // Matrix Hessian
        // $d1 = 1 * 1 * (3.887122 + (0.5*0.5));
        // $d2 = 1 * 0 * (0.030843 + (0.5*0.5));
        // $d3 = -1 * 1 * (0.026361 + (0.5*0.5));
        // dd($d3);



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
