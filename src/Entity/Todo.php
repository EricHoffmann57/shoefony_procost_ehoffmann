<?php

namespace App\Entity;

use App\Repository\Company\TodoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TodoRepository::class)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Project::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false, onDelete:"CASCADE")]
    #[Assert\NotBlank(message: 'This field cannot be empty')]
    private ?Project $project;


    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'This field cannot be empty')]
    private ?int $devTime;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: 'This field cannot be empty')]
    private ?Employee $employee;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $released;

    public function __construct()
    {
        $this->released = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;

        return $this;
    }


    public function getDevTime(): ?int
    {
        return $this->devTime;
    }

    public function setDevTime(int $devTime): self
    {
        $this->devTime = $devTime;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getReleased(): ?\DateTimeInterface
    {
        return $this->released;
    }

    public function setReleased(\DateTimeInterface $released): self
    {
        $this->released = $released;

        return $this;
    }
}