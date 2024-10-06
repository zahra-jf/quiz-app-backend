<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Skill;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $skills = Skill::all();
        foreach ($skills as $skill) {
            foreach (range(1, 10) as $index) {
                Question::create([
                    'skill_id' => $skill->id,
                    'title' => $faker->sentence,
                    'description' => $faker->paragraph,
                    'answer_id' => null,
                    'order' => $index,
                    'status' => $faker->boolean,
                    'image' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
