<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "rol", type: "string")]
#[ORM\DiscriminatorMap(["user" => User::class, "admin" => Administrador::class, "treballador" => Treballador::class, "client" => Client::class])]
#[ORM\HasLifecycleCallbacks]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "El nombre de usuario no puede estar vacío.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "El nombre de usuario no puede tener más de 50 caracteres."
    )]
    #[ORM\Column(length: 50)]
    private ?string $nom_usuari = null;

    #[Assert\NotBlank(message: "La contraseña no puede estar vacía.")]
    #[ORM\Column(length: 255)]
    private ?string $contrasenya = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El nombre no puede estar vacío.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "El nombre no puede tener más de 50 caracteres."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El apellido no puede estar vacío.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "El apellido no puede tener más de 50 caracteres."
    )]
    private ?string $cognom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El correo no puede estar vacío.")]
    #[Assert\Email(message: "Por favor, introduce un correo válido.")]
    #[Assert\Length(
        max: 50,
        maxMessage: "El correo no puede tener más de 50 caracteres."
    )]
    private ?string $correu = null;

    #[ORM\Column(type: Types::JSON)]
    #[Assert\NotNull(message: "El rol no puede estar vacío.")]
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

    public function jsonSerialize(): mixed
    {
        return[
            "id" => $this->getId(),
            "nom_usuari" => $this->getNomUsuari(),
            "nom" => $this->getNom(),
            "cognom" => $this->getCognom(),
            "correu" => $this->getCorreu(),
            "rols" => $this->getRols(),
        ];
    }
}
