<?php

namespace App\Entity\Articles;

use App\Entity\User;
use App\Repository\Articles\CartRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
* @ORM\Entity(repositoryClass=CartRepository::class)
*/
class Cart
{
/**
* @ORM\Id
* @ORM\GeneratedValue
* @ORM\Column(type="integer")
*/
private ?int $id = null;

/**
* @ORM\ManyToOne(targetEntity=User::class, inversedBy="carts")
* @ORM\JoinColumn(nullable=false)
*/
private ?User $user = null;

/**
* @ORM\OneToMany(targetEntity=CartItem::class, mappedBy="cart", cascade={"persist", "remove"})
*/
private Collection $items;

public function __construct()
{
$this->items = new ArrayCollection();
}

public function getId(): ?int
{
return $this->id;
}

public function getUser(): ?User
{
return $this->user;
}

public function setUser(User $user): self
{
$this->user = $user;
return $this;
}

/**
* @return Collection<int, CartItem>
*/
public function getItems(): Collection
{
return $this->items;
}

public function addItem(CartItem $item): self
{
if (!$this->items->contains($item)) {
$this->items[] = $item;
$item->setCart($this);
}

return $this;
}

public function removeItem(CartItem $item): self
{
$this->items->removeElement($item);

return $this;
}
}
