<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $phoneNr;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEmail = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPhone = 0;

    /**
     * @ORM\Column(type="string", length=23)
     */
    private $photo ="";

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ActCode", mappedBy="user", cascade={"persist", "remove"})
     */
    private $actCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Car", mappedBy="user", orphanRemoval=true)
     */
    private $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNr(): ?string
    {
        return $this->phoneNr;
    }

    public function setPhoneNr(?string $phoneNr): self
    {
        $this->phoneNr = $phoneNr;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $date_18 = new \DateTime("-18 years");
        $date_99 = new \DateTime("-99 years");
        if( $dateOfBirth <= $date_18  && $dateOfBirth >= $date_99 ){
            $this->dateOfBirth = $dateOfBirth;
        }

        return $this;
    }

    public function getIsEmail(): ?bool
    {
        return $this->isEmail;
    }

    public function setIsEmail(bool $isEmail): self
    {
        $this->isEmail = $isEmail;

        return $this;
    }

    public function getIsPhone(): ?bool
    {
        return $this->isPhone;
    }

    public function setIsPhone(bool $isPhone): self
    {
        $this->isPhone = $isPhone;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getActCode(): ?ActCode
    {
        return $this->actCode;
    }

    public function setActCode(?ActCode $actCode): self
    {
        $this->actCode = $actCode;

        // set (or unset) the owning side of the relation if necessary
        $newUser = $actCode === null ? null : $this;
        if ($newUser !== $actCode->getUser()) {
            $actCode->setUser($newUser);
        }

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setUser($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->contains($car)) {
            $this->cars->removeElement($car);
            // set the owning side to null (unless already changed)
            if ($car->getUser() === $this) {
                $car->setUser(null);
            }
        }

        return $this;
    }
}
