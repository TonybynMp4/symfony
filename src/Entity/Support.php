<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"support:read"}},
 *     denormalizationContext={"groups"={"support:write"}},
 * )
 * @ORM\Entity
 */
class Support
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id")
     * @Groups({"support:read", "support:write"})
     */
    private $theme;

    /**
     * @ORM\ManyToOne(targetEntity="Theme")
     * @ORM\JoinColumn(name="subtheme_id", referencedColumnName="id")
     * @Groups({"support:read", "support:write"})
     */
    private $subtheme;

    /**
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Groups({"support:read", "support:write"})
     */
    private $title;

    /**
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Groups({"support:read", "support:write"})
     */
    private $subtitle;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Groups({"support:read", "support:write"})
     */
    private $type;

    /**
     *
     * @ORM\Column(type="text", length=2500)
     * @Assert\NotBlank
     * @Groups({"support:read", "support:write"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"support:read", "support:write"})
     */
    private $validate = false;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class)
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"support:read", "support:write"})
     */
    public $image;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"support:read", "support:write"})
     */
    private $zoom;

    /**
     *
     * @ORM\Column(type="text", length=2500)
     * @Assert\NotBlank
     * @Groups({"support:read", "support:write"})
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="supports")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="UserHasFavoriteSupport", mappedBy="support", orphanRemoval=true)
     */
    private $usersFavorites;

    /**
     * @ORM\OneToMany(targetEntity="UserHasListSupport", mappedBy="support", orphanRemoval=true)
     */
    private $usersLists;

    /**
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"event:read", "event:write"})
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->usersLists = new ArrayCollection();
        $this->usersFavorites = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Support
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param mixed $theme
     * @return Support
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Support
     */
    public function setTitle(string $title): Support
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     * @return Support
     */
    public function setSubtitle(string $subtitle): Support
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Support
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Support
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isValidate(): bool
    {
        return $this->validate;
    }

    /**
     * @param bool $validate
     * @return Support
     */
    public function setValidate(bool $validate): Support
    {
        $this->validate = $validate;
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
     * @return Support
     */
    public function setImage(?MediaObject $image): Support
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZoom()
    {
        return $this->zoom;
    }

    /**
     * @param mixed $zoom
     * @return Support
     */
    public function setZoom($zoom)
    {
        $this->zoom = $zoom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * @param mixed $legend
     * @return Support
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubtheme()
    {
        return $this->subtheme;
    }

    /**
     * @param mixed $subtheme
     * @return Support
     */
    public function setSubtheme($subtheme)
    {
        $this->subtheme = $subtheme;
        return $this;
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

    public function getUsersFavorites()
    {
        return $this->usersFavorites;
    }

    public function addUserFavorite(UserHasFavoriteSupport $userHasFavoriteSupport): self
    {
        if (!$this->usersFavorites->contains($userHasFavoriteSupport)) {
            $this->usersFavorites[] = $userHasFavoriteSupport;
            $userHasFavoriteSupport->setSupport($this);
        }

        return $this;
    }

    public function removeUserFavorite(UserHasFavoriteSupport $userHasFavoriteSupport): self
    {
        if ($this->usersFavorites->contains($userHasFavoriteSupport)) {
            $this->usersFavorites->removeElement($userHasFavoriteSupport);
            // set the owning side to null (unless already changed)
            if ($userHasFavoriteSupport->getSupport() === $this) {
                $userHasFavoriteSupport->setSupport(null);
            }
        }

        return $this;
    }

    public function getUsersLists()
    {
        return $this->usersLists;
    }

    public function addUserList(UserHasListSupport $userHasListSupport): self
    {
        if (!$this->usersLists->contains($userHasListSupport)) {
            $this->usersLists[] = $userHasListSupport;
            $userHasListSupport->setSupport($this);
        }

        return $this;
    }

    public function removeUserList(UserHasListSupport $userHasListSupport): self
    {
        if ($this->usersLists->contains($userHasListSupport)) {
            $this->usersLists->removeElement($userHasListSupport);
            // set the owning side to null (unless already changed)
            if ($userHasListSupport->getSupport() === $this) {
                $userHasListSupport->setSupport(null);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Support
     */
    public function setCreatedAt(\DateTime $createdAt): Support
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}