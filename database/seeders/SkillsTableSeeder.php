<?php

namespace Database\Seeders;

use App\Models\Skill;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        foreach (range(1, 5) as $index) {
            Skill::create([
                'name' => $faker->word,
                'duration' => $faker->numberBetween(5, 20),
                'description' => $faker->sentence,
                'status' => $faker->boolean,
                'difficulty' => $faker->numberBetween(0, 2),
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
