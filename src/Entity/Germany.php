<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GermanyRepository")
 */
class Germany
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $plz;

    /**
     * @ORM\Column(type="string", length=39)
     */
    private $ort;

    /**
     * @ORM\Column(type="string", length=22)
     */
    private $bundesland;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlz(): ?int
    {
        return $this->plz;
    }

    public function setPlz(int $plz): self
    {
        $this->plz = $plz;

        return $this;
    }

    public function getOrt(): ?string
    {
        return $this->ort;
    }

    public function setOrt(string $ort): self
    {
        $this->ort = $ort;

        return $this;
    }

    public function getBundesland(): ?string
    {
        return $this->bundesland;
    }

    public function setBundesland(string $bundesland): self
    {
        $this->bundesland = $bundesland;

        return $this;
    }
}
