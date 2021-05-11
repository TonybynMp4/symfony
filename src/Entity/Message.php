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
 *     collectionOperations={
 *          "get"={},
 *          "post"={},
 *          "getTchatBetweenUser"={
 *              "method"="GET",
 *              "path"="/messages/tchat/{ownerId}/{userDeliveryId}",
 *              "requirements"={"ownerId"="\d+", "userDeliveryId"="\d+"},
 *              "controller"=App\Controller\TchatBetweenUser::class
 *          },
 *          "getTchatList"={
 *              "method"="GET",
 *              "path"="/messages/tchat/list/{ownerId}",
 *              "requirements"={"ownerId"="\d+"},
 *              "controller"=App\Controller\TchatList::class
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
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
    private $view = false;

    /**
     *
     * @ORM\Column(type="string", length=250)
     * @Groups({"message:read"})
     */
    private $conversation;

    /**
     * @var integer
     * @Groups({"message:read"})
     */
    private $nbUnread;

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
    public function isView(): bool
    {
        return $this->view;
    }

    /**
     * @param bool $view
     * @return Message
     */
    public function setView(bool $view): Message
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * @param mixed $conversation
     * @return Message
     */
    public function setConversation($conversation)
    {
        $this->conversation = $conversation;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbUnread(): int
    {
        return $this->nbUnread;
    }

    /**
     * @param int $nbUnread
     * @return Message
     */
    public function setNbUnread(int $nbUnread): Message
    {
        $this->nbUnread = $nbUnread;
        return $this;
    }
}