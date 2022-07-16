<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::create([
            'quote' => 'This is quote 1',
            'review' => 'Tuna bakarnya enak. Tekstur daging lembut. Kauh asam juga enak. Mantap rasanya. Pokoknya semua enak. Lokasi, pelayanan, jus juga enak.',
        ]);
        Review::create([
            'quote' => 'This is quote 2',
            'review' => 'Salah satu tempat makan yang saya rekomendasikan di Manado. Daging tuna bakarnya sangat lembut dan empuk. Sambal dabu-dabunya juga sangat enak.',
        ]);
    }
}
