<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

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
    use TimestampableEntity;


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
     * @ORM\Column(type="string", length=25, nullable=true)
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
     * @Assert\Range(
     *      max = 3,
     *      maxMessage = "Not more than {{ limit }}cm to enter"
     * )
     */
    private $maxPassangers =0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ride", mappedBy="car", cascade={"persist", "remove"} )
     */
    private $rides;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="car")
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;


    public function __construct()
    {
        $this->rides = new ArrayCollection();
    }


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

    /**
     * @return Collection|Ride[]
     */
    public function getRides(): Collection
    {
        return $this->rides;
    }

    public function addRide(Ride $ride): self
    {
        if (!$this->rides->contains($ride)) {
            $this->rides[] = $ride;
            $ride->setCar($this);
        }

        return $this;
    }

    public function removeRide(Ride $ride): self
    {
        if ($this->rides->contains($ride)) {
            $this->rides->removeElement($ride);
            // set the owning side to null (unless already changed)
            if ($ride->getCar() === $this) {
                $ride->setCar(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}
