<?php

namespace App\Domain;

class Quiz
{
    /**
     * @param Question[] $questions
     */
    public function __construct(
        public readonly array $questions,
    ) {
    }
}