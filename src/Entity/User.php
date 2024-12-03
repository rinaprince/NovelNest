<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "rol", type: "string")]
#[ORM\DiscriminatorMap(["user" => User::class, "admin" => Administrador::class, "treballador" => Treballador::class, "client" => Client::class])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_usuari = null;

    #[ORM\Column(length: 255)]
    private ?string $contrasenya = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $cognom = null;

    #[ORM\Column(length: 50)]
    private ?string $correu = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $rols = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNomUsuari(): ?string
    {
        return $this->nom_usuari;
    }

    public function setNomUsuari(string $nom_usuari): static
    {
        $this->nom_usuari = $nom_usuari;

        return $this;
    }

    public function getContrasenya(): ?string
    {
        return $this->contrasenya;
    }

    public function setContrasenya(string $contrasenya): static
    {
        $this->contrasenya = $contrasenya;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCognom(): ?string
    {
        return $this->cognom;
    }

    public function setCognom(string $cognom): static
    {
        $this->cognom = $cognom;

        return $this;
    }

    public function getCorreu(): ?string
    {
        return $this->correu;
    }

    public function setCorreu(string $correu): static
    {
        $this->correu = $correu;

        return $this;
    }

    public function getRols(): array
    {
        return $this->rols;
    }

    public function setRols(array $rols): static
    {
        $this->rols = $rols;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->contrasenya;
    }

    public function getRoles(): array
    {
        return $this->rols;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getNomUsuari();
    }
}
