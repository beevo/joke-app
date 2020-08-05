<?php

namespace App\Entity;

use App\Repository\JokeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JokeRepository::class)
 */
class Joke
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $setup;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $punchline;

    /**
     * @ORM\Column(type="integer")
     */
    private $laughs;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSetup(): ?string
    {
        return $this->setup;
    }

    public function setSetup(string $setup): self
    {
        $this->setup = $setup;

        return $this;
    }

    public function getPunchline(): ?string
    {
        return $this->punchline;
    }

    public function setPunchline(string $punchline): self
    {
        $this->punchline = $punchline;

        return $this;
    }

    public function getLaughs(): ?int
    {
        return $this->laughs;
    }

    public function setLaughs(int $laughs): self
    {
        $this->laughs = $laughs;

        return $this;
    }
}
