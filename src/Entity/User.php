<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;  // Importation des validations

#[ORM\Entity]
class User implements PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 4)]
    private ?string $user_Initial = null;

    #[ORM\Column(length: 100)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100)]
    private ?string $last_name = null;

    // Validation pour l'email
    #[Assert\Email(message: "L'adresse email n'est pas valide.")]
    #[Assert\Regex(
        pattern: "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.(fr|com)$/",
        message: "L'adresse email doit être de la forme nom@nom.fr ou nom@nom.com."
    )]
    #[ORM\Column(length: 150, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private ?array $roles = [];

    // Validation pour le mot de passe
    #[Assert\Length(min: 6, minMessage: "Le mot de passe doit comporter au moins 6 caractères.")]
    #[Assert\Regex(
        pattern: "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/",
        message: "Le mot de passe doit contenir au moins une lettre majuscule, une minuscule, un chiffre et un caractère spécial."
    )]
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\ManyToOne(targetEntity: Newsletter::class)]
    #[ORM\JoinColumn(name: "newsletter_id", referencedColumnName: "id", nullable: true)]
    private ?Newsletter $newsletter = null;

    // Getters et setters

    public function getId(): ?int
    {
        return $this->user_id;
    }

    public function getUserInitial(): ?string
    {
        return $this->user_Initial;
    }

    public function setUserInitial(?string $user_initial): static
    {
        $this->user_Initial = $user_initial;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // Les utilisateurs ont au moins le ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    // Cette méthode est requise par l'interface PasswordAuthenticatedUserInterface
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getNewsletter(): ?Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(?Newsletter $newsletter): static
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    // méthode pour générer les initiales
    public function generateUserInitial(): void
    {
        $this->user_Initial = strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        if ($this->user_Initial === null) {
            $this->generateUserInitial();
        }
    }
}
