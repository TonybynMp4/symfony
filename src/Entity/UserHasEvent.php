<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserHasEventRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"UserHasEvent:read"}},
 *     denormalizationContext={"groups"={"UserHasEvent:write"}},
 *     collectionOperations={
 *          "get"={},
 *          "post"={},
 *          "getEventParticipation"={
 *              "method"="GET",
 *              "path"="/user_has_events/coming/list/{userId}/{type}",
 *              "requirements"={"userId"="\d+", "type"="pub|priv|all"},
 *              "controller"=App\Controller\EventListComing::class,
 *              "normalization_context"={"groups"={"EventListComing"}}
 *          },
 *          "getEventsByUserId"={
 *              "method"="GET",
 *              "path"="/user_has_events/all/{userId}",
 *              "requirements"={"userId"="\d+"},
 *              "controller"=App\Controller\EventUser::class
 *          },
 *          
 *     },
 *     itemOperations={
 *         "get"={},
 *         "updateParticipation"={
 *              "method"="PATCH",
 *              "path"="/user_has_events/participation/{userId}/{eventId}",
 *              "requirements"={"userId"="\d+", "eventId"="\d+"},
 *              "controller"=App\Controller\EventParticipation::class,
 *              "read"=false
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserHasEventRepository")
 * @ORM\Table(
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="unique",
 *              columns={"user_id", "event_id"}
 *          )
 *    }
 * )
 */
class UserHasEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"event:read", "event:write"})
     *
     * @Serializer\Expose
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:read", "user:write", "UserHasEvent:read", "EventListComing"})
     */
    private $event;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"event:read", "event:write"})
     */
    private $accepted = false;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    /**
     * @param bool $accepted
     * @return UserHasEvent
     */
    public function setAccepted(bool $accepted): UserHasEvent
    {
        $this->accepted = $accepted;
        return $this;
    }
}
