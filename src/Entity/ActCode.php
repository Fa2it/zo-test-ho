<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActCodeRepository")
 */
class ActCode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="actCode", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $emailCode;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $phoneCode;

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

    public function getEmailCode(): ?string
    {
        return $this->emailCode;
    }

    public function setEmailCode(string $emailCode): self
    {
        $this->emailCode = $emailCode;

        return $this;
    }

    public function getPhoneCode(): ?string
    {
        return $this->phoneCode;
    }

    public function setPhoneCode(string $phoneCode): self
    {
        $this->phoneCode = $phoneCode;

        return $this;
    }
}
