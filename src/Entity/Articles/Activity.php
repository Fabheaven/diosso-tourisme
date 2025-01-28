<?php

namespace App\Entity\Articles;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;

#[ORM\Entity]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)] // Ajout du champ description
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)] // Ajout du champ price
    private ?float $price = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)] // Ajout du champ image
    private ?string $image = null;

    #[ORM\ManyToMany(targetEntity: Circuit::class, mappedBy: 'activities')]
    private Collection $circuits;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'activities')]
    private Collection $users; // Relation inverse N,N avec User

    public function __construct()
    {
        $this->circuits = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    // Getters and setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return Collection<int, Circuit>
     */
    public function getCircuits(): Collection
    {
        return $this->circuits;
    }

    public function addCircuit(Circuit $circuit): self
    {
        if (!$this->circuits->contains($circuit)) {
            $this->circuits->add($circuit);
            $circuit->addActivity($this); // Met à jour l'autre côté de la relation
        }

        return $this;
    }

    public function removeCircuit(Circuit $circuit): self
    {
        if ($this->circuits->removeElement($circuit)) {
            $circuit->removeActivity($this); // Met à jour l'autre côté de la relation
        }

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers($users)
    {
        $this->users = $users;
        return $this;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }
        return $this;
    }
}
