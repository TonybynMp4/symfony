<?php
// api/src/Entity/Theme.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource
 * @ORM\Entity
 */
class Theme
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank
     */
    public $name;

    /**
     * @ORM\OneToMany(targetEntity="UserHasTheme", mappedBy="theme", orphanRemoval=true)
     */
    private $users;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     */
    public $image;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Theme
     */
    public function setName(string $name): Theme
    {
        $this->name = $name;
        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(UserHasTheme $userHasTheme): self
    {
        if (!$this->users->contains($userHasTheme)) {
            $this->users[] = $userHasTheme;
            $userHasTheme->setTheme($this);
        }

        return $this;
    }

    public function removeUser(UserHasTheme $userHasTheme): self
    {
        if ($this->users->contains($userHasTheme)) {
            $this->users->removeElement($userHasTheme);
            // set the owning side to null (unless already changed)
            if ($userHasTheme->getTheme() === $this) {
                $userHasTheme->setTheme(null);
            }
        }

        return $this;
    }
}