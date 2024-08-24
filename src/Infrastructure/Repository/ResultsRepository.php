<?php

namespace App\Infrastructure\Repository;

use App\Domain\QuizResultDto;
use App\Infrastructure\Entity\QuizResult;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ResultsRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ) {
    }

    public function save(QuizResultDto $dto)
    {
        $quizResult = new QuizResult();
        $quizResult->setResults($dto->questions);

        $this->entityManager->persist($quizResult);
        $this->entityManager->flush();
    }
}