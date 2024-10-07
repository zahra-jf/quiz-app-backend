<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\QuestionIndexRequest;
use App\Http\Requests\Api\v1\SkillIndexRequest;
use App\Models\Skill;
use App\Service\SkillService;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    private SkillService $skillService;
    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    public function index(SkillIndexRequest $request)
    {
         return $this->skillService->getSkills();
    }

    public function questions(QuestionIndexRequest $request)
    {
        return $this->skillService->getQuestions($request['skill_id']);
    }

}
