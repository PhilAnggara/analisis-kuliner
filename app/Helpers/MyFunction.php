<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class MyFunction
{
    public static function caseFolding($data)
    {
        $result = collect();

        foreach ($data as $item) {

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
}
