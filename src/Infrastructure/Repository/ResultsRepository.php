<?php

namespace App\Infrastructure\Repository;

use App\Domain\Quiz;
use App\Domain\QuizResultDto;
use App\Infrastructure\Entity\Answer;
use \App\Domain\Answer as AnswerDomain;
use App\Infrastructure\Entity\Question;
use \App\Domain\Question as QuestionDomain;
use App\Infrastructure\Entity\QuizResult;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\Serializer\SerializerInterface;

class ResultsRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    )
    {
    }

    public function save(QuizResultDto $dto)
    {
        $quizResult = new QuizResult();
        $quizResult->setResults($dto->questions);

        $this->entityManager->persist($quizResult);
        $this->entityManager->flush();
    }
}