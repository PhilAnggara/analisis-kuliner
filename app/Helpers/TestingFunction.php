<?php

namespace App\Helpers;

class TestingFunction
{
    public static function readJson($file)
    {
        $jsonData = collect(json_decode(file_get_contents(storage_path('/app/public/json/'.$file.'.json'), true)));
        $result = collect();
        foreach ($jsonData as $item) {
            $result->push(collect($item)->toArray());
        }

        return $result;
    }
    
    public static function tf($words, $stemming)
    {
        $result = collect();
        foreach ($words as $word) {
            $d = collect();
            foreach ($stemming as $stm) {
                $i = 0;
                foreach ($stm['review'] as $s) {
                    if ($word == $s) {
                        $i++;
                    }
                }
                $d->push($i / count($stm['review']));
            }
            $result->push([
                'kata' => $word,
                'data' => $d,
            ]);
        }

        return $result;
    }
}
