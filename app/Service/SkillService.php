<?php

namespace App\Service;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Skill;

class SkillService
{
    public function getSkills()
    {
        return Skill::active()->get()->groupBy('tag');
    }

    public function getQuestions(int $skill_id)
    {
        try {
            $questions = Question::where('skill_id', $skill_id)
                ->orderBy('order', 'desc')
                ->with('options')
                ->get();
            $quiz = $this->createQuiz($skill_id, $questions);
            return ['success' => true, 'quiz_id' => $quiz->id, 'questions' => $questions];
        } catch (\Exception $exception) {
            logger($exception->getMessage());
            return ['success' => false, 'message' => 'There is a problem with getting questions.'];
        }

    }

    public function createQuiz($skill_id, $questions)
    {
        return Quiz::create([
            'skill_id' => $skill_id,
            'user_id' => auth()->user()->id,
            'total_questions' => $questions->count(),
        ]);
    }
}
