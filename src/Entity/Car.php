<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 *
 * @UniqueEntity(
 *      fields={"user","brand","model"},
 *      errorPath="model",
 *      message="Modell für eine bestimmte Marke ist bereits in der Datenbank vorhanden."
 * )
 *
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isChating;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSmoking;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMusic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPets;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxPassangers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIsChating(): ?bool
    {
        return $this->isChating;
    }

    public function setIsChating(bool $isChating): self
    {
        $this->isChating = $isChating;

        return $this;
    }

    public function getIsSmoking(): ?bool
    {
        return $this->isSmoking;
    }

    public function setIsSmoking(bool $isSmoking): self
    {
        $this->isSmoking = $isSmoking;

        return $this;
    }

    public function getIsMusic(): ?bool
    {
        return $this->isMusic;
    }

    public function setIsMusic(bool $isMusic): self
    {
        $this->isMusic = $isMusic;

        return $this;
    }

    public function getIsPets(): ?bool
    {
        return $this->isPets;
    }

    public function setIsPets(bool $isPets): self
    {
        $this->isPets = $isPets;

        return $this;
    }

    public function getMaxPassangers(): ?int
    {
        return $this->maxPassangers;
    }

    public function setMaxPassangers(int $maxPassangers): self
    {
        $this->maxPassangers = $maxPassangers;

        return $this;
    }
}
