<?php

namespace App\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class FrontController extends AbstractController
{
    #[Route('/', methods: 'GET')]
    public function index(): Response
    {
        return $this->render('quiz.html.twig');
    }

}