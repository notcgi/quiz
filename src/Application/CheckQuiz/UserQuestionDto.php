<?php

namespace App\Application\CheckQuiz;


class UserQuestionDto
{
    /** @param  UserAnswerDto[] $answers */
    public function __construct(
        public readonly int $id,
        public readonly array $answers
    )
    {
    }
}