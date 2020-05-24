<?php

namespace App\Entity;

use App\Repository\PhoneBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhoneBookRepository::class)
 */
class PhoneBook
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @ORM\Column(type="string", length=17)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="phoneBooks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Shared::class, mappedBy="phoneBook")
     */
    private $shareds;

    /**
     * PhoneBook constructor.
     */
    public function __construct()
    {
        $this->shareds = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     *
     * @return PhoneBook
     */
    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     *
     * @return PhoneBook
     */
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|object|null $user
     *
     * @return PhoneBook
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Shared[]
     */
    public function getShareds(): Collection
    {
        return $this->shareds;
    }

    /**
     * @param Shared $shared
     *
     * @return PhoneBook
     */
    public function addShared(Shared $shared): self
    {
        if (!$this->shareds->contains($shared)) {
            $this->shareds[] = $shared;
            $shared->setPhoneBook($this);
        }

        return $this;
    }

    /**
     * @param Shared $shared
     *
     * @return PhoneBook
     */
    public function removeShared(Shared $shared): self
    {
        if ($this->shareds->contains($shared)) {
            $this->shareds->removeElement($shared);
            // set the owning side to null (unless already changed)
            if ($shared->getPhoneBook() === $this) {
                $shared->setPhoneBook(null);
            }
        }

        return $this;
    }
}
