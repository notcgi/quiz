<?php

namespace App\Domain;

class QuizResultDto
{
    /**
     * @param QuestionResultDto[] $questions
     */
    public function __construct(
        public readonly array $questions
    ) {
    }
}