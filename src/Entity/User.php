<?php
// api/src/Entity/User.php

namespace App\Entity;

use App\Entity\UserHasPersonality;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity(fields={"email"})
 * @ApiResource(
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read", "user:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"user:read", "user:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user:read", "user:write"})
     */
    private $birthdate;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user:read", "user:write"})
     */
    private $gender;

    /**
     * @return int|null
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups({"user:read", "user:write"})
     */
    private $idSubscription;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"user:read", "user:write"})
     */
    public $image;

    /**
     * @ORM\OneToMany(targetEntity="UserHasPersonality", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     * @Groups({"user:read", "user:write"})
     */
    private $personalities;

    /**
     * @ORM\OneToMany(targetEntity="UserHasTheme", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $themes;

    /**
     * @ORM\OneToMany(targetEntity="UserHasLanguage", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $languages;

    public function __construct() {
        $this->personalities = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->languages = new ArrayCollection();
        $this->roles[] = "ROLE_USER";
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

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate) : self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdSubscription()
    {
        return $this->idSubscription;
    }

    /**
     * @param mixed $idSubscription
     * @return User
     */
    public function setIdSubscription($idSubscription) :self
    {
        $this->idSubscription = $idSubscription;
        return $this;
    }

    public function getPersonalities()
    {
        return $this->personalities;
    }

    public function addPersonality(UserHasPersonality $userHasPersonality): self
    {
        if (!$this->personalities->contains($userHasPersonality)) {
            $this->personalities[] = $userHasPersonality;
            $userHasPersonality->setUser($this);
        }

        return $this;
    }

    public function removePersonality(UserHasPersonality $userHasPersonality): self
    {
        if ($this->personalities->contains($userHasPersonality)) {
            $this->personalities->removeElement($userHasPersonality);
            // set the owning side to null (unless already changed)
            if ($userHasPersonality->getUser() === $this) {
                $userHasPersonality->setUser(null);
            }
        }

        return $this;
    }

    public function getThemes()
    {
        return $this->themes;
    }

    public function addTheme(UserHasTheme $userHasTheme): self
    {
        if (!$this->themes->contains($userHasTheme)) {
            $this->themes[] = $userHasTheme;
            $userHasTheme->setUser($this);
        }

        return $this;
    }

    public function removeTheme(UserHasTheme $userHasTheme): self
    {
        if ($this->themes->contains($userHasTheme)) {
            $this->themes->removeElement($userHasTheme);
            // set the owning side to null (unless already changed)
            if ($userHasTheme->getUser() === $this) {
                $userHasTheme->setUser(null);
            }
        }

        return $this;
    }

    public function getLanguages()
    {
        return $this->languages;
    }

    public function addLanguage(UserHasLanguage $userHasLanguage): self
    {
        if (!$this->languages->contains($userHasLanguage)) {
            $this->languages[] = $userHasLanguage;
            $userHasLanguage->setUser($this);
        }

        return $this;
    }

    public function removeLanguage(UserHasLanguage $userHasLanguage): self
    {
        if ($this->themes->contains($userHasLanguage)) {
            $this->themes->removeElement($userHasLanguage);
            // set the owning side to null (unless already changed)
            if ($userHasLanguage->getUser() === $this) {
                $userHasLanguage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return MediaObject|null
     */
    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    /**
     * @param MediaObject|null $image
     * @return User
     */
    public function setImage(?MediaObject $image): User
    {
        $this->image = $image;
        return $this;
    }
}
