<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SupportHasMediaRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"support:read", "media_object:read"}},
 *     denormalizationContext={"groups"={"support:write", "media_object:write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SupportHasMediaRepository")
 * @ORM\Table(
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="unique",
 *              columns={"support_id", "media_id"}
 *          )
 *    }
 * )
 */
class SupportHasMedia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Support", inversedBy="medias", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"media_object:read", "media_object:write"})
     *
     * @Serializer\Expose
     */
    private $support;

    /**
     * @ORM\ManyToOne(targetEntity="MediaObject", inversedBy="supports", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"support:read", "support:write", "userHasFavoriteSupport:read"})
     */
    private $media;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupport(): ?Support
    {
        return $this->support;
    }

    public function setSupport(?Support $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getMedia(): ?MediaObject
    {
        return $this->media;
    }

    public function setMedia(?MediaObject $media): self
    {
        $this->media = $media;

        return $this;
    }
}