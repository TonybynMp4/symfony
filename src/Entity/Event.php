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
 *     normalizationContext={"groups"={"event:read"}},
 *     denormalizationContext={"groups"={"event:write"}},
 * )
 * @ORM\Entity
 */
class Event
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Theme", orphanRemoval=true)
     * @ORM\JoinColumn(name="theme_id", referencedColumnName="id")
     * @Groups({"event:read", "event:write"})
     */
    private $theme;

    /**
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Groups({"event:read", "event:write"})
     */
    private $title;

    /**
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"event:read", "event:write"})
     */
    private $timeToStart;

    /**
     *
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank
     * @Groups({"event:read", "event:write"})
     */
    private $duration;

    /**
     *
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Groups({"event:read", "event:write"})
     */
    private $place;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"event:read", "event:write"})
     */
    private $supportType;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"event:read", "event:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"event:read", "event:write"})
     */
    private $level;

    /**
     * @ORM\OneToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     * @Groups({"event:read", "event:write"})
     */
    private $language;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"event:read", "event:write"})
     */
    public $image;

    /**
     *
     * @ORM\Column(type="text", length=2500, nullable=true)
     * @Assert\NotBlank
     * @Groups({"event:read", "event:write"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="UserHasEvent", mappedBy="event")
     * @Groups({"event:read", "event:write"})
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity="User", orphanRemoval=true)
     * @Groups({"event:read", "event:write"})
     */
    private $owner;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"event:read", "event:write"})
     */
    private $nbMaxParticipants;

    /**
     *
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank
     * @Groups({"event:read", "event:write"})
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="event", cascade={"remove"})
     * @Groups({"event:read", "event:write"})
     */
    private $messages;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->messages = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Event
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
     * @return Event
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeToStart()
    {
        return $this->timeToStart;
    }

    /**
     * @param mixed $timeToStart
     * @return Event
     */
    public function setTimeToStart($timeToStart)
    {
        $this->timeToStart = $timeToStart;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     * @return Event
     */
    public function setPlace($place)
    {
        $this->place = $place;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSupportType()
    {
        return $this->supportType;
    }

    /**
     * @param mixed $supportType
     * @return Event
     */
    public function setSupportType($supportType)
    {
        $this->supportType = $supportType;
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
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @return Event
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $language
     * @return Event
     */
    public function setLanguage($language)
    {
        $this->language = $language;
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
     * @return Event
     */
    public function setImage(?MediaObject $image): Event
    {
        $this->image = $image;
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
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function addUser(UserHasEvent $userHasEvent): self
    {
        if (!$this->users->contains($userHasEvent)) {
            $this->users[] = $userHasEvent;
            $userHasEvent->setEvent($this);
        }

        return $this;
    }

    public function removeUser(UserHasEvent $userHasEvent): self
    {
        if ($this->users->contains($userHasEvent)) {
            $this->users->removeElement($userHasEvent);
            // set the owning side to null (unless already changed)
            if ($userHasEvent->getEvent() === $this) {
                $userHasEvent->setEvent(null);
            }
        }

        return $this;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setEvent($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            // set the owning side to null (unless already changed)
            if ($message->getEvent() === $this) {
                $message->setEvent(null);
            }
        }

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
     * @return Event
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNbMaxParticipants()
    {
        return $this->nbMaxParticipants;
    }

    /**
     * @param mixed $nbMaxParticipants
     * @return Event
     */
    public function setNbMaxParticipants($nbMaxParticipants)
    {
        $this->nbMaxParticipants = $nbMaxParticipants;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Event
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     * @return Event
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }
}