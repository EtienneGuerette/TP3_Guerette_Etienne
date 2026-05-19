<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AverageRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $averageRatings = DB::table('critics')
            ->select('film_id', DB::raw('AVG(score) as average_score'))
            ->groupBy('film_id')
            ->get();
        foreach ($averageRatings as $averageRating) {
            DB::table('average_ratings')->insert([
                'film_id' => $averageRating->film_id,
                'average_score' => $averageRating->average_score,
            ]);
        }
    }
}
