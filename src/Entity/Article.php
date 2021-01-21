<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @ORM\Column(type="float")
     */
    private $prixht;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteht;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrixht(): ?float
    {
        return $this->prixht;
    }

    public function setPrixht(float $prixht): self
    {
        $this->prixht = $prixht;

        return $this;
    }

    public function getQuantiteht(): ?int
    {
        return $this->quantiteht;
    }

    public function setQuantiteht(int $quantiteht): self
    {
        $this->quantiteht = $quantiteht;

        return $this;
    }
}
