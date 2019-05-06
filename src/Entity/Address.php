<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $houseNr;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $postNr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $town;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="address")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Car", mappedBy="address")
     */
    private $car;

    public function __construct()
    {
        $this->car = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouseNr(): ?string
    {
        return $this->houseNr;
    }

    public function setHouseNr(string $houseNr): self
    {
        $this->houseNr = $houseNr;

        return $this;
    }

    public function getPostNr(): ?string
    {
        return $this->postNr;
    }

    public function setPostNr(string $postNr): self
    {
        $this->postNr = $postNr;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getCar(): Collection
    {
        return $this->car;
    }

    public function addCar(Car $car): self
    {
        if (!$this->car->contains($car)) {
            $this->car[] = $car;
            $car->setAddress($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->car->contains($car)) {
            $this->car->removeElement($car);
            // set the owning side to null (unless already changed)
            if ($car->getAddress() === $this) {
                $car->setAddress(null);
            }
        }

        return $this;
    }


}
