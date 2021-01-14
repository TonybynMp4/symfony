<?php

namespace App\Entity;

use App\Repository\UserHasPersonalityRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=UserHasPersonalityRepository::class)
 * @ORM\Table(
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="unique",
 *              columns={"user_id", "personality_id"}
 *          )
 *    }
 * )
 */
class UserHasPersonality
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="personalities", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Expose
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Personality", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personality;

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

    public function getPersonality(): ?Personality
    {
        return $this->personality;
    }

    public function setPersonality(?Personality $personality): self
    {
        $this->personality = $personality;

        return $this;
    }
}
