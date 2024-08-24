<?php

namespace App\Application\GetQuiz;

use App\Infrastructure\Repository\QuizRepository;

class GetQuizHandler
{
    public function __construct(
        private readonly QuizRepository $quizRepository,
    )
    {
    }

    public function __invoke()
    {
        return $this->quizRepository->get();
    }
}