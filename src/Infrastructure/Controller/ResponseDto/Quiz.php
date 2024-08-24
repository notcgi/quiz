<?php

namespace App\Infrastructure\Controller\ResponseDto;

class Quiz
{
    /**
     * @var Question[]
     */
    public readonly array $questions;

    public function __construct(
        \App\Domain\Quiz $quiz
    ) {
        $this->questions = array_values(
            array_map(
                static fn(\App\Domain\Question $question) => new Question($question),
                $quiz->questions
            )
        );
    }
}