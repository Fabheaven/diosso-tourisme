<?php

namespace App\Entity\Articles;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
class Activity
{
#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column(type: 'integer')]
private ?int $id = null;

#[ORM\Column(length: 255)]
private ?string $name = null;

#[ORM\ManyToMany(targetEntity: Circuit::class, mappedBy: 'activities')]
private Collection $circuits;

public function __construct()
{
$this->circuits = new ArrayCollection();
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
}
