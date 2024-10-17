<?php

namespace App\Service;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class QuizService
{

    protected Quiz $quiz;

    public function getQuiz(int $quiz_id)
    {
        $quiz = Quiz::whereNull('completed_at')->where('id', $quiz_id)->first();
        if ($quiz) {
            return ['success' => false, 'message' => 'Quiz not found or answered'];
        }
        $this->quiz = $quiz;
        return $this;
    }

    public function checkAnswers($data)
    {
        try {
            DB::beginTransaction();
            $user = User::find(auth()->user()->id);

            $score = 0;
            foreach ($data['answers'] as $answer) {

                $question = Question::find($answer['question_id']);

                $result = Result::create([
                    'user_id' => $user->id,
                    'quiz_id' => $this->quiz->id,
                    'question_id' => $question->id,
                    'option_id' => $answer['answer_id'],
                ]);
                $correctAnswer = $question->answer_id;

                if ($answer['answer_id'] === $correctAnswer) {
                    $score++;
                    $result->is_correct = true;
                    $result->save();
                }
            }
            $totalAnswers = count($data['answers']);

            $this->quiz->update([
                'total_answers' => $totalAnswers,
                'correct_answers' => $score,
                'wrong_answers' => $totalAnswers - $score,
                'completed_at' => now(),
            ]);

            $user->update(['score' => $score]);
            DB::commit();
            return ['success' => true, 'score' => $score];
        } catch (\Exception $exception) {
            DB::rollBack();
            return ['success' => false];
        }
    }


}
