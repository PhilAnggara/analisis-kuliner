<?php

namespace App\Http\Controllers;

use App\Helpers\MyFunction;
use App\Helpers\TestingFunction;
use App\Models\Restaurant;
use App\Models\Review;
use Goutte\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Phpml\Classification\SVC;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Tokenization\WhitespaceTokenizer;

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
 
    public function scraping()
    {
        // return response()->json($this->scraper());
        // return response()->json($this->getReviews());
    }

    public function testing()
    {
        $total = 200;
        $trainNumber = $total -1;

        $reviews = Review::all()->take($total);
        $case_folding = MyFunction::caseFolding($reviews);
        $tokenizing = MyFunction::tokenizing($case_folding);
        $filtering = MyFunction::filtering($tokenizing);

        $stemming = MyFunction::stemming($filtering);
        $stemming = TestingFunction::readJson('stemmed_3');

        $samples = [];
        foreach ($stemming as $item) {
            $sentence = implode(' ', $item['review']);
            $samples[] = $sentence;
        }
        $labels = MyFunction::getClass($stemming)->toArray();

        // Token Count Vectorizer
        $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
        $vectorizer->fit($samples);
        $vectorizer->transform($samples);

        // Tf-idf Transformer
        $transformer = new TfIdfTransformer($samples);
        $transformer->transform($samples);

        // SVC
        $training = collect($samples)->take($trainNumber)->toArray();
        $labels = collect($labels)->take($trainNumber)->toArray();
        $testing = last($samples);

        $classifier = new SVC(Kernel::LINEAR, $cost = 1000);
        $classifier->train($training, $labels);

        $test = $classifier->predict([
            $testing
        ]);

        dd($test);
    }

    public function testing1()
    {
        $reviews = Review::all()->take(10);
        $case_folding = MyFunction::caseFolding($reviews);
        $tokenizing = MyFunction::tokenizing($case_folding);
        $filtering = MyFunction::filtering($tokenizing);

        $stemming = MyFunction::stemming($filtering);
        // $stemming = TestingFunction::readJson('stemmed_3');

        $words = MyFunction::getWords($stemming);

        $termFrequency = MyFunction::tf($words, $stemming);
        // $termFrequency = TestingFunction::tf($words, $stemming);

        $inverseDocumentFrequency = MyFunction::idf($termFrequency, $stemming);
        $tfidf = MyFunction::tfidf($termFrequency, $inverseDocumentFrequency);
        $kernel = MyFunction::kernel($tfidf, MyFunction::getClass($stemming));
        $hessian = MyFunction::hessian($kernel);
        $error = MyFunction::error($hessian);
        $delta = MyFunction::delta($error);
        $alpha = MyFunction::alpha($delta);

        return view('pages.testing', [
            'reviews' => $reviews,
            'case_folding' => $case_folding,
            'tokenizing' => $tokenizing,
            'filtering' => $filtering,
            'stemming' => $stemming,
            'words' => $words,
            'termFrequency' => $termFrequency,
            'inverseDocumentFrequency' => $inverseDocumentFrequency,
            'tfidf' => $tfidf,
            'kernel' => $kernel,
            'hessian' => $hessian,
            'error' => $error,
            'delta' => $delta,
            'alpha' => $alpha,
        ]);
    }
}
