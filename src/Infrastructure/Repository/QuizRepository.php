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
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class QuizRepository
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly DenormalizerInterface $serializer,
    )
    {
    }

    public function get(): Quiz
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
            SELECT q.*, a.*, q_rand
            FROM (
                SELECT *, random() AS q_rand
                FROM question
                ORDER BY q_rand
                LIMIT 10
            ) q
            INNER JOIN answer a ON q.id = a.question_id
            ORDER BY q_rand, random()
        ';

        $stmt = $conn->prepare($sql);
        $result = $stmt->executeQuery()->fetchAllAssociative();

        $questions = [];
        foreach ($result as $row) {
            $questionId = $row['question_id'];
            if (!isset($questions[$questionId])) {
                $questions[$questionId] = [
                    'id' => $questionId,
                    'question_text' => $row['question_text'],
                    'answers' => []
                ];
            }
            $questions[$questionId]['answers'][] = [
                'id' => $row['id'],
                'answer_text' => $row['answer_text'],
                'is_correct' => $row['is_correct']
            ];
        }

        return $this->serializer->denormalize(compact('questions'), Quiz::class);
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