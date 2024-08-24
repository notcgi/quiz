<?php

namespace App\Infrastructure\Controller\RequestDto;

class Question
{

    public readonly int $id;
    public readonly string $questionText;
    /** @var Answer[] */
    public readonly array $answers;
    public function __construct(
        \App\Domain\Question $question
    )
    {
        $this->id = $question->id;
        $this->questionText = $question->questionText;
        $this->answers = array_map(
            static fn(\App\Domain\Answer $answer) =>  new Answer($answer),
            $question->answers
        );
    }
}