<?php

namespace App\Domain;

class Question
{
    /**
     * @param Answer[] $answers
     */
    public function __construct(
        public readonly int $id,
        public readonly string $questionText,
        public readonly array $answers,
    ) {
    }
}