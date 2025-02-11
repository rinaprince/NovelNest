<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tipus = null;

    #[ORM\Column(length: 255)]
    private ?string $num_factura = null;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private ?float $preu = null;

    #[ORM\Column(type: "integer")]
    private ?int $quantitat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'factura', targetEntity: Obra::class, cascade: ['remove'])]
    private Collection $obres;

    public function __construct()
    {
        $this->obres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObres(): Collection
    {
        return $this->obres;
    }

    public function getTipus(): ?string
    {
        return $this->tipus;
    }

    public function setTipus(?string $tipus): void
    {
        $this->tipus = $tipus;
    }

    public function getNumFactura(): ?string
    {
        return $this->num_factura;
    }

    public function setNumFactura(?string $num_factura): void
    {
        $this->num_factura = $num_factura;
    }

    public function getPreu(): ?float
    {
        return $this->preu;
    }

    public function setPreu(?float $preu): void
    {
        $this->preu = $preu;
    }

    public function getQuantitat(): ?int
    {
        return $this->quantitat;
    }

    public function setQuantitat(?int $quantitat): void
    {
        $this->quantitat = $quantitat;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): void
    {
        $this->client = $client;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "tipus" => $this->tipus,
            "num_factura" => $this->num_factura,
            "preu" => $this->preu,
            "quantitat" => $this->quantitat,
            "client" => $this->client?->getId(),
            "obres" => $this->obres->map(fn($obra) => $obra->jsonSerialize())->toArray(),
        ];
    }
}
