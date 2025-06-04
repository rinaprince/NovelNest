<?php

namespace App\Entity;

use App\Repository\CarritoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarritoRepository::class)]
class Carrito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $usuariCompra = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $obra = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $data_creacio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $quantitat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuariCompra(): ?string
    {
        return $this->usuariCompra;
    }

    public function setUsuariCompra(?string $usuariCompra): static
    {
        $this->usuariCompra = $usuariCompra;

        return $this;
    }

    public function getObra(): ?string
    {
        return $this->obra;
    }

    public function setObra(?string $obra): static
    {
        $this->obra = $obra;

        return $this;
    }

    public function getDataCreacio(): ?\DateTimeInterface
    {
        return $this->data_creacio;
    }

    public function setDataCreacio(\DateTimeInterface $data_creacio): static
    {
        $this->data_creacio = $data_creacio;

        return $this;
    }

    public function getQuantitat(): ?string
    {
        return $this->quantitat;
    }

    public function setQuantitat(?string $quantitat): static
    {
        $this->quantitat = $quantitat;

        return $this;
    }

    public function getPreu(): ?string
    {
        return $this->preu;
    }

    public function setPreu(?string $preu): static
    {
        $this->preu = $preu;

        return $this;
    }
}
