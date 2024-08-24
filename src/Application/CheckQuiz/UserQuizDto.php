<?php

namespace App\Application\CheckQuiz;

class UserQuizDto
{
    /** @param UserQuestionDto[] $questions */
    public function __construct(public readonly array $questions)
    {
    }
}