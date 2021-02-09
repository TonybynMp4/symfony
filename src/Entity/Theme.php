<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"theme:read"}},
 *     denormalizationContext={"groups"={"theme:write"}},
 * )
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
     * @Groups({"theme:read", "theme:write"})
     */
    public $name;

    /**
     * @ORM\OneToOne(targetEntity="Theme", mappedBy="id", orphanRemoval=true)
     * @Groups({"theme:read", "theme:write"})
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="UserHasTheme", mappedBy="theme", orphanRemoval=true)
     * @Groups({"theme:read", "theme:write"})
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="UserHasFavoriteTheme", mappedBy="theme", orphanRemoval=true)
     * @Groups({"theme:read", "theme:write"})
     */
    private $usersFavorites;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"theme:read", "theme:write"})
     */
    public $image;

    public function __construct()
    {
        $this->usersFavorites = new ArrayCollection();
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

    public function getUsersFavorites()
    {
        return $this->usersFavorites;
    }

    public function addUserFavorite(UserHasFavoriteTheme $userHasFavoriteTheme): self
    {
        if (!$this->usersFavorites->contains($userHasFavoriteTheme)) {
            $this->usersFavorites[] = $userHasFavoriteTheme;
            $userHasFavoriteTheme->setTheme($this);
        }

        return $this;
    }

    public function removeUserFavorite(UserHasFavoriteTheme $userHasFavoriteTheme): self
    {
        if ($this->usersFavorites->contains($userHasFavoriteTheme)) {
            $this->usersFavorites->removeElement($userHasFavoriteTheme);
            // set the owning side to null (unless already changed)
            if ($userHasFavoriteTheme->getTheme() === $this) {
                $userHasFavoriteTheme->setTheme(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return Theme
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
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
     * @return Theme
     */
    public function setImage(?MediaObject $image): Theme
    {
        $this->image = $image;
        return $this;
    }
}