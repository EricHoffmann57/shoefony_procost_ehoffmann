<?php

namespace App\Entity;

use App\Repository\Company\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private ?int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"This field cannot be empty")]
    private ?string $name;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank(message:"This field cannot be empty")]
    private ?string $description;

    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message:"This field cannot be empty")]
    private ?int $sellingPrice;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank(message:"This field cannot be empty")]
    private \DateTimeInterface $created_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $releaseDate = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSellingPrice(): ?int
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(int $sellingPrice): self
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

}