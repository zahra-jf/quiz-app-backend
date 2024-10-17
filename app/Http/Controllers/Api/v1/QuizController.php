<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\QuizAnswerRequest;
use App\Service\QuizService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quizService)
    {
    }

    public function answer(QuizAnswerRequest $request)
    {
        $result = $this->quizService->getQuiz($request['quiz_id'])->checkAnswers($request);
        if ($result['success']) {
            return $this->success([
                'message' => 'Quiz submitted successfully!',
                'data' => [
                    'score' => $result['score'],
                ],
            ]);
        }
        return $this->error(['message' => $result['message']]);
    }
}
