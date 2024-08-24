<?php

namespace App\Domain;

class QuestionResultDto
{
    public function __construct(
        public readonly int $id,
        public readonly bool $isCorrect
    ) {
    }
}