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

    #[ORM\ManyToOne(inversedBy: 'id_Factura')]
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

    public function getTipus(): ?string
    {
        return $this->tipus;
    }

    public function setTipus(string $tipus): static
    {
        $this->tipus = $tipus;
        return $this;
    }

    public function getNumFactura(): ?string
    {
        return $this->num_factura;
    }

    public function setNumFactura(string $num_factura): static
    {
        $this->num_factura = $num_factura;
        return $this;
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

    public function setClient(?Client $client): static
    {
        $this->client = $client;
        return $this;
    }

    public function getObres(): Collection
    {
        return $this->obres;
    }

    public function addObra(Obra $obra): static
    {
        if (!$this->obres->contains($obra)) {
            $this->obres[] = $obra;
            $obra->setFactura($this);
        }

        return $this;
    }

    public function removeObra(Obra $obra): static
    {
        if ($this->obres->removeElement($obra)) {
            if ($obra->getFactura() === $this) {
                $obra->setFactura(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "tipus" => $this->getTipus(),
            "num_factura" => $this->getNumFactura(),
            "preu" => $this->getPreu(),
            "quantitat" => $this->getQuantitat(),
            "client" => $this->getClient()?->getId(),
            "obres" => $this->getObres()->map(fn($obra) => $obra->jsonSerialize())->toArray(),
        ];
    }
}
