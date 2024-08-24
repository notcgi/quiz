<?php

namespace App\Application\CheckQuiz;

class UserAnswerDto
{
    public readonly int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}