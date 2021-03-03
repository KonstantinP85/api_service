<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    private const ACTIVE = 1;
    private const BAN = 0;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

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
     * @ORM\Column(type="boolean")
     */
    private $is_ban;

    /**
     * @ORM\OneToMany(targetEntity=FirstComment::class, mappedBy="user")
     */
    private $firstComments;

    public function __construct()
    {
        $this->firstComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setActive()
    {
        $this->is_ban = self::ACTIVE;
    }

    public function setBan()
    {
        $this->is_ban = self::BAN;
    }

    public function getStatus(): bool
    {
        return (bool) $this->is_ban;
    }

    /**
     * @return Collection|FirstComment[]
     */
    public function getFirstComments(): Collection
    {
        return $this->firstComments;
    }

    public function addFirstComment(FirstComment $firstComment): self
    {
        if (!$this->firstComments->contains($firstComment)) {
            $this->firstComments[] = $firstComment;
            $firstComment->addUser($this);
        }

        return $this;
    }

    public function removeFirstComment(FirstComment $firstComment): self
    {
        if ($this->firstComments->removeElement($firstComment)) {
            $firstComment->removeUser($this);
        }

        return $this;
    }
}
