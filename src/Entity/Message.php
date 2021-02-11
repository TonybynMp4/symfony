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
 *     normalizationContext={"groups"={"message:read"}},
 *     denormalizationContext={"groups"={"message:write"}},
 * )
 * @ORM\Entity
 */
class Message
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="text", length=2500)
     * @Assert\NotBlank
     * @Groups({"message:read", "message:write"})
     */
    private $content;

    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     * @Groups({"message:read", "message:write"})
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @Groups({"message:read", "message:write"})
     */
    private $userDelivery;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="messages")
     * @Groups({"message:read", "message:write"})
     */
    private $event;

    /**
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"message:read", "message:write"})
     */
    private $lastUpdated;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"message:read", "message:write"})
     */
    private $read = false;

    public function __construct()
    {
        $this->lastUpdated = new \DateTime();
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
     * @return Message
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     * @return Message
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserDelivery()
    {
        return $this->userDelivery;
    }

    /**
     * @param mixed $userDelivery
     * @return Message
     */
    public function setUserDelivery($userDelivery)
    {
        $this->userDelivery = $userDelivery;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     * @return Message
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdated(): \DateTime
    {
        return $this->lastUpdated;
    }

    /**
     * @param \DateTime $lastUpdated
     * @return Message
     */
    public function setLastUpdated(\DateTime $lastUpdated): Message
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRead(): bool
    {
        return $this->read;
    }

    /**
     * @param bool $read
     * @return Message
     */
    public function setRead(bool $read): Message
    {
        $this->read = $read;
        return $this;
    }
}