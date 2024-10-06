<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\Question;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        $questions = Question::all();

        foreach ($questions as $question) {
            $optionsCount = $faker->numberBetween(2, 5);

            foreach (range(1, $optionsCount) as $index) {
                $option = Option::create([
                    'question_id' => $question->id,
                    'text' => $faker->sentence,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Update the question's answer_id to the first option created for the question
                if ($index === 1) {
                    $question->answer_id = $option->id;
                    $question->save();
                }
            }
        }
    }
}
