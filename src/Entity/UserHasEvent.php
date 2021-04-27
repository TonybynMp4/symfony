<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserHasThemeRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"event:read"}},
 *     denormalizationContext={"groups"={"event:write"}},
 *     collectionOperations={
 *          "get"={},
 *          "post"={},
 *          "getEventParticipation"={
 *              "method"="GET",
 *              "path"="/userHasEvent/coming/list/{userId}",
 *              "requirements"={"userId"="\d+"},
 *              "controller"=App\Controller\EventListComing::class
 *          }
 *     },
 *     itemOperations={
 *         "get"={},
 *         "patch"={},
 *         "updateParticipation"={
 *             "method"="PATCH",
 *             "path"="/userHasEvent/participation/{userId}/{eventId}",
 *             "requirements"={"userId"="\d+", "eventId"="\d+"},
 *             "controller"=App\Controller\EventParticipation::class
 *         }
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
     * @Groups({"user:read", "user:write"})
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
