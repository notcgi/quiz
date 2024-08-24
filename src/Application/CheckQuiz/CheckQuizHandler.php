<?php

namespace App\Application\CheckQuiz;

use App\Domain\QuestionResultDto;
use App\Domain\Quiz;
use App\Domain\QuizResultDto;
use App\Infrastructure\Repository\QuizRepository;

class CheckQuizHandler
{
    public function __construct(
        private readonly QuizRepository $quizRepository,
    )
    {
    }

    public function __invoke(UserQuizDto $userQuizDto): QuizResultDto
    {
        $questionIds = $this->getQuestionIds($userQuizDto);
        $quiz = $this->quizRepository->getByIds($questionIds);

        $correctAnswers = $this->mapQuizToCorrectAnsers($quiz);

        $results = [];

        foreach ($userQuizDto->questions as $userQuestion) {
            $correctAnswerIds = $correctAnswers[$userQuestion->id] ?? [];
            $isCorrect = $this->isCorrect($userQuestion, $correctAnswerIds);

            $results[] = new QuestionResultDto($userQuestion->id, $isCorrect);
        }

        return new QuizResultDto($results);
    }

    private function isCorrect(UserQuestionDto $userQuestion, array $correctAnswerIds): bool
    {
        $userAnswers = array_map(
            static fn($answer) => $answer->id,
            $userQuestion->answers);
        $intersection = array_intersect($userAnswers, $correctAnswerIds);

        // there are not only correct answers
        if (count($intersection) < count($userAnswers)) {
            return false;
        }
        // user did not answer
        if (count($intersection) > 0 && count($userAnswers) === 0)
        {
            return false;
        }

        return true;
    }

    private function getQuestionIds(UserQuizDto $userQuizDto)
    {
        return array_map(static fn(UserQuestionDto $question) => $question->id, $userQuizDto->questions);
    }

    /**
     * @param Quiz $quiz
     * @return array{int: int[]}
     */
    private function mapQuizToCorrectAnsers(Quiz $quiz)
    {
        $correctAnswers = [];

        foreach ($quiz->questions as $question) {
            $correctAnswers[$question->id] = array_map(
                static fn($answer) => $answer->id,
                array_filter($question->answers, static fn($answer) => $answer->isCorrect)
            );
        }

        return $correctAnswers;
    }
}