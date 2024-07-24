<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SpeciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Species::create([
                'name' => $faker->name,
                'breed' => $faker->word,
                'heartRateLowAlarm' => $faker->numberBetween(60, 80),
                'heartRateHighAlarm' => $faker->numberBetween(100, 120),
                'respiratoryRateLowAlarm' => $faker->numberBetween(10, 20),
                'respiratoryRateHighAlarm' => $faker->numberBetween(25, 35),
                'coreTempLowAlarm' => $faker->randomFloat(2, 36.0, 37.0),
                'coreTempHighAlarm' => $faker->randomFloat(2, 38.0, 39.0),
            ]);
        }
    }
}
