<?php

namespace App\Infrastructure\Controller;

use App\Application\CheckQuiz\CheckQuizHandler;
use App\Application\CheckQuiz\UserQuizDto;
use App\Application\GetQuiz\GetQuizHandler;
use App\Infrastructure\Controller\ResponseDto\Quiz;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('api/v1/quiz')]
class ApiController
{
    #[Route('/', methods: 'GET')]
    public function getQuiz(
        GetQuizHandler $handler
    ): JsonResponse {
        $quiz = ($handler)();

        return new JsonResponse(new Quiz($quiz));
    }

    #[Route('/', methods: ['POST'])]
    public function answerQuiz(
        Request $request,
        SerializerInterface $serializer,
        CheckQuizHandler $handler
    ): JsonResponse {
        $userQuizDto = $serializer->deserialize(
            $request->getContent(),
            UserQuizDto::class,
            'json'
        );

        $result = ($handler)($userQuizDto);

        return new JsonResponse($result);
    }
}