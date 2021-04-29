<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SupportHasMediaObjectRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SupportHasMediaObjectRepository::class)
 * @ORM\Table(
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="unique",
 *              columns={"support_id", "media_object_id"}
 *          )
 *    }
 * )
 */
class SupportHasMediaObject
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
     *
     * @Serializer\Expose
     */
    private $support;

    /**
     * @ORM\ManyToOne(targetEntity="MediaObject", inversedBy="events", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"support:read", "support:write"})
     */
    private $mediaObject;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSupport()
    {
        return $this->support;
    }

    /**
     * @param mixed $support
     * @return SupportHasMediaObject
     */
    public function setSupport($support)
    {
        $this->support = $support;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMediaObject()
    {
        return $this->mediaObject;
    }

    /**
     * @param mixed $mediaObject
     * @return SupportHasMediaObject
     */
    public function setMediaObject($mediaObject)
    {
        $this->mediaObject = $mediaObject;
        return $this;
    }
}