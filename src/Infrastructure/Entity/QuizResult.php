<?php

namespace App\Infrastructure\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'quiz_results')]
class QuizResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'json')]
    private array $results;

    public function getId(): int
    {
        return $this->id;
    }

    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): self
    {
        $this->results = $results;
        return $this;
    }
}