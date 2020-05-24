<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=PhoneBook::class, mappedBy="user")
     */
    private $phoneBooks;

    /**
     * @ORM\OneToMany(targetEntity=Shared::class, mappedBy="sharedByUser")
     */
    private $sharedByUsers;

    /**
     * @ORM\OneToMany(targetEntity=Shared::class, mappedBy="sharedWithUser")
     */
    private $sharedWithUsers;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->phoneBooks = new ArrayCollection();
        $this->sharedByUsers = new ArrayCollection();
        $this->sharedWithUsers = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param array $roles
     *
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|PhoneBook[]
     */
    public function getPhoneBooks(): Collection
    {
        return $this->phoneBooks;
    }

    /**
     * @param PhoneBook $phoneBook
     *
     * @return User
     */
    public function addPhoneBook(PhoneBook $phoneBook): self
    {
        if (!$this->phoneBooks->contains($phoneBook)) {
            $this->phoneBooks[] = $phoneBook;
            $phoneBook->setUser($this);
        }

        return $this;
    }

    /**
     * @param PhoneBook $phoneBook
     *
     * @return User
     */
    public function removePhoneBook(PhoneBook $phoneBook): self
    {
        if ($this->phoneBooks->contains($phoneBook)) {
            $this->phoneBooks->removeElement($phoneBook);
            // set the owning side to null (unless already changed)
            if ($phoneBook->getUser() === $this) {
                $phoneBook->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Shared[]
     */
    public function getSharedByUsers(): Collection
    {
        return $this->sharedByUsers;
    }

    /**
     * @param Shared $sharedByUser
     *
     * @return User
     */
    public function addSharedByUser(Shared $sharedByUser): self
    {
        if (!$this->sharedByUsers->contains($sharedByUser)) {
            $this->sharedByUsers[] = $sharedByUser;
            $sharedByUser->setSharedByUser($this);
        }

        return $this;
    }

    /**
     * @param Shared $sharedByUser
     *
     * @return User
     */
    public function removeSharedByUser(Shared $sharedByUser): self
    {
        if ($this->sharedByUsers->contains($sharedByUser)) {
            $this->sharedByUsers->removeElement($sharedByUser);
            // set the owning side to null (unless already changed)
            if ($sharedByUser->getSharedByUser() === $this) {
                $sharedByUser->setSharedByUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Shared[]
     */
    public function getSharedWithUsers(): Collection
    {
        return $this->sharedWithUsers;
    }

    /**
     * @param Shared $sharedWithUser
     *
     * @return User
     */
    public function addSharedWithUser(Shared $sharedWithUser): self
    {
        if (!$this->sharedWithUsers->contains($sharedWithUser)) {
            $this->sharedWithUsers[] = $sharedWithUser;
            $sharedWithUser->setSharedWithUser($this);
        }

        return $this;
    }

    /**
     * @param Shared $sharedWithUser
     *
     * @return User
     */
    public function removeSharedWithUser(Shared $sharedWithUser): self
    {
        if ($this->sharedWithUsers->contains($sharedWithUser)) {
            $this->sharedWithUsers->removeElement($sharedWithUser);
            // set the owning side to null (unless already changed)
            if ($sharedWithUser->getSharedWithUser() === $this) {
                $sharedWithUser->setSharedWithUser(null);
            }
        }

        return $this;
    }
}
