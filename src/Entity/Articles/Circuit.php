<?php

namespace App\Entity\Articles;

use App\Repository\Articles\CircuitRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CircuitRepository::class)]
class Circuit
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type: 'integer')]
private ?int $id = null;

#[ORM\Column(length: 255)]
private ?string $name = null;

#[ORM\Column(type: 'text')]
private ?string $description = null;

#[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
private ?float $price = null;

#[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'circuits')]
private Collection $activities;

public function __construct()
{
$this->activities = new ArrayCollection();
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

public function setDescription(string $description): self
{
$this->description = $description;
return $this;
}

public function getPrice(): ?float
{
return $this->price;
}

public function setPrice(float $price): self
{
$this->price = $price;
return $this;
}

/**
* @return Collection<int, Activity>
*/
public function getActivities(): Collection
{
return $this->activities;
}

public function addActivity(Activity $activity): self
{
if (!$this->activities->contains($activity)) {
$this->activities->add($activity);
}

return $this;
}

public function removeActivity(Activity $activity): self
{
$this->activities->removeElement($activity);

return $this;
}
}
