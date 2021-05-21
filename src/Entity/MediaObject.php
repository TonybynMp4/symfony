<?php
// api/src/Entity/MediaObject.php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\CreateMediaObjectAction;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ApiResource(
 *     iri="http://schema.org/MediaObject",
 *     normalizationContext={"groups"={"media_object_read"}},
 *     collectionOperations={
 *         "post"={
 *             "controller"=CreateMediaObjectAction::class,
 *             "deserialize"=false,
 *             "validation_groups"={"Default", "media_object_create"},
 *             "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *         },
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @Vich\Uploadable
 */
class MediaObject
{
    /**
     * @var int|null
     *
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"media_object_read"})
     */
    public $contentUrl;

    /**
     * @var File|null
     *
     * @Assert\NotNull(groups={"media_object_create"})
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    public $file;

    /**
     * @var string|null
     *
     * @ORM\Column(nullable=true)
     * @Groups({"theme:read", "user:read", "support:read", "event:read", "media_object_read", "userHasFavoriteSupport:read", "FavoriteThemeUser", "message:read", "EventListComing", "SearchSupport"})
     */
    public $filePath;

    /**
     *
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"support:read", "media_object_read"})
     */
    public $description;

    /**
     * @ORM\OneToMany(targetEntity="SupportHasMedia", mappedBy="media")
     */
    private $supports;

    public function __construct()
    {
        $this->supports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    /**
     * @param string|null $contentUrl
     * @return MediaObject
     */
    public function setContentUrl(?string $contentUrl): MediaObject
    {
        $this->contentUrl = $contentUrl;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @param File|null $file
     * @return MediaObject
     */
    public function setFile(?File $file): MediaObject
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    /**
     * @param string|null $filePath
     * @return MediaObject
     */
    public function setFilePath(?string $filePath): MediaObject
    {
        $this->filePath = $filePath;
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
     * @return MediaObject
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getSupports()
    {
        return $this->supports;
    }

    public function addSupport(SupportHasMedia $supportHasMedia): self
    {
        if (!$this->supports->contains($supportHasMedia)) {
            $this->supports[] = $supportHasMedia;
            $supportHasMedia->setMedia($this);
        }

        return $this;
    }

    public function removeSupport(SupportHasMedia $supportHasMedia): self
    {
        if ($this->supports->contains($supportHasMedia)) {
            $this->supports->removeElement($supportHasMedia);
            // set the owning side to null (unless already changed)
            if ($supportHasMedia->getMedia() === $this) {
                $supportHasMedia->setMedia(null);
            }
        }

        return $this;
    }
}