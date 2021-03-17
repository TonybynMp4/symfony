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
 *     collectionOperations={
 *          "get"={},
 *          "post"={},
 *          "getSupportsByUser"={
 *              "method"="GET",
 *              "path"="/supports/user/{userId}",
 *              "requirements"={"userId"="\d+"},
 *              "controller"=App\Controller\SupportUser::class
 *          },
 *          "searchSupportsByLetters"={
 *              "method"="GET",
 *              "path"="/supports/search/{letters}",
 *              "controller"=App\Controller\SearchSupport::class
 *          },
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SupportRepository")
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
     * @ORM\JoinColumn(name="subtheme_id", referencedColumnName="id", nullable=false)
     * @Groups({"support:read", "support:write"})
     */
    private $subTheme;

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
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"support:read", "support:write"})
     */
    public $image;

    /**
     *
     * @ORM\Column(type="text", length=2500)
     * @Assert\NotBlank
     * @Groups({"support:read", "support:write"})
     */
    private $legend;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="supports")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @Groups({"support:read", "support:write"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="UserHasFavoriteSupport", mappedBy="support")
     */
    private $usersFavorites;

    /**
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"support:read", "support:write"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"support:read", "support:write"})
     */
    private $level;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     * @return Support
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubTheme()
    {
        return $this->subTheme;
    }

    /**
     * @param mixed $subTheme
     * @return Support
     */
    public function setSubTheme($subTheme)
    {
        $this->subTheme = $subTheme;
        return $this;
    }
}