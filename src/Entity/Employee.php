<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\Company\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ORM\Table(name: 'app_employee')]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'This field cannot be empty')]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'This field cannot be empty')]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'This field cannot be empty')]
    #[Assert\Email(message: 'email address must be valid')]
    private ?string $email = null;

    #[ORM\ManyToOne(targetEntity: Job::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Job $job;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message: 'this field cannot be empty')]
    private ?string $dailyCost = null;

    #[ORM\Column(type: 'datetime')]
    private \datetimeInterface $hiringDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getDailyCost(): ?string
    {
        return $this->dailyCost;
    }

    public function setDailyCost(?string $dailyCost): self
    {
        $this->dailyCost = $dailyCost;
        return $this;
    }

    public function getHiringDate(): \DateTimeInterface
    {
        return $this->hiringDate;
    }


    public function setHiringDate(\DateTimeInterface $hiringDate):self
    {
        $this->hiringDate = $hiringDate;
    }
}
