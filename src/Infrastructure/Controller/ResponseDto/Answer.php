<?php

namespace App\Infrastructure\Controller\ResponseDto;

class Answer
{
    public readonly int $id;
        public readonly string $answerText;
    public function __construct(
        \App\Domain\Answer $answer
    )
    {
        $this->id = $answer->id;
        $this->answerText = $answer->answerText;
    }
}