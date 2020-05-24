<?php

namespace App\Entity;

use App\Repository\SharedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SharedRepository::class)
 */
class Shared
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PhoneBook::class, inversedBy="shareds")
     */
    private $phoneBook;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sharedByUsers")
     */
    private $sharedByUser;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sharedWithUsers")
     */
    private $sharedWithUser;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return PhoneBook|null
     */
    public function getPhoneBook(): ?PhoneBook
    {
        return $this->phoneBook;
    }

    /**
     * @param PhoneBook|null $phoneBook
     *
     * @return Shared
     */
    public function setPhoneBook(?PhoneBook $phoneBook): self
    {
        $this->phoneBook = $phoneBook;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getSharedByUser(): ?User
    {
        return $this->sharedByUser;
    }

    /**
     * @param User|object|null $sharedByUser
     *
     * @return Shared
     */
    public function setSharedByUser(?User $sharedByUser): self
    {
        $this->sharedByUser = $sharedByUser;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getSharedWithUser(): ?User
    {
        return $this->sharedWithUser;
    }

    /**
     * @param User|object|null $sharedWithUser
     *
     * @return Shared
     */
    public function setSharedWithUser(?User $sharedWithUser): self
    {
        $this->sharedWithUser = $sharedWithUser;

        return $this;
    }
}
