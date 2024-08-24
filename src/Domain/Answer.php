<?php

namespace App\Domain;

class Answer
{
    public function __construct(
        public readonly int $id,
        public readonly string $answerText,
        public readonly bool $isCorrect,
    )
    {
    }
}