<?php

namespace App\Infrastructure\Repository;

use App\Domain\Quiz;
use App\Infrastructure\Entity\Answer;
use \App\Domain\Answer as AnswerDomain;
use App\Infrastructure\Entity\Question;
use \App\Domain\Question as QuestionDomain;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;

class QuizRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function get(): Quiz
    {
        $qb = $this->entityManager
            ->createQueryBuilder();
        //todo answers > 1?
        $query = $qb
            ->select('q, a')
            ->from(Question::class, 'q')
            ->join('q.answers', 'a')
            ->setMaxResults(10)
            ->getQuery();

        /** @var Question[] $result */
        $result = $query->getResult();

        return $this->mapToDomain($result);
    }

    /**
     * @param int[] $ids
     * @return Quiz
     */
    public function getByIds(array $ids): Quiz
    {
        sort($ids);
        $qb = $this->entityManager
            ->createQueryBuilder();
        $query = $qb
            ->select('q, a')
            ->from(Question::class, 'q')
            ->join('q.answers', 'a')
            ->where($qb->expr()->in('q.id', ':ids'))
            ->setMaxResults(10)
            ->setParameters(new ArrayCollection([
                new Parameter('ids', $ids)
            ]))
            ->getQuery();

        /** @var Question[] $result */
        $result = $query->getResult();

        return $this->mapToDomain($result);
    }

    private function mapToDomain(array $result): Quiz
    {
        return new Quiz(
            array_map(fn(Question $question) => new QuestionDomain(
                id: $question->getId(),
                questionText: $question->getQuestionText(),
                answers: array_map(
                    fn(Answer $answer) => new AnswerDomain(
                        id: $answer->getId(),
                        answerText: $answer->getAnswerText(),
                        isCorrect: $answer->getIsCorrect()
                    ),
                    $question->getAnswers()->toArray()
                )
            )
                , $result)
        );
    }
}