<?php

namespace App\Service;

use App\Models\Question;
use App\Models\Skill;

class SkillService
{
    public function getSkills()
    {
       return Skill::active()->get();
    }

    public function getQuestions(mixed $skill_id)
    {
        return Question::active()->where('skill_id', $skill_id)
            ->orderBy('order','desc')
            ->with('options')
            ->get();
    }
}
