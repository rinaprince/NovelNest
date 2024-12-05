<?php

namespace App\Entity;

use App\Repository\ObraRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObraRepository::class)]
class Obra implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $tipus = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $numObra_seguiment = null;

    #[ORM\Column]
    private ?bool $estat = null;

    #[ORM\ManyToOne(inversedBy: 'obres')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $pseudonim_client = null;

    #[ORM\Column(length: 255)]
    private ?string $portada = null;

    #[ORM\ManyToOne(inversedBy: 'num_Obra')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Arxiu $url_arxiu = null;

    #[ORM\ManyToOne(inversedBy: 'obra')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Factura $factura = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function getTipus(): ?string
    {
        return $this->tipus;
    }

    public function setTipus(?string $tipus): void
    {
        $this->tipus = $tipus;
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

    public function getNumObraSeguiment(): ?int
    {
        return $this->numObra_seguiment;
    }

    public function setNumObraSeguiment(int $numObra_seguiment): static
    {
        $this->numObra_seguiment = $numObra_seguiment;
        return $this;
    }

    public function isEstat(): ?bool
    {
        return $this->estat;
    }

    public function setEstat(bool $estat): static
    {
        $this->estat = $estat;
        return $this;
    }

    public function getPseudonimClient(): ?Client
    {
        return $this->pseudonim_client;
    }

    public function setPseudonimClient(?Client $pseudonim_client): static
    {
        $this->pseudonim_client = $pseudonim_client;
        return $this;
    }

    public function getPortada(): ?string
    {
        return $this->portada;
    }

    public function setPortada(string $portada): static
    {
        $this->portada = $portada;
        return $this;
    }

    public function getUrlArxiu(): ?Arxiu
    {
        return $this->url_arxiu;
    }

    public function setUrlArxiu(?Arxiu $url_arxiu): static
    {
        $this->url_arxiu = $url_arxiu;
        return $this;
    }

    public function getFactura(): ?Factura
    {
        return $this->factura;
    }

    public function setFactura(Factura $factura): static
    {
        $this->factura = $factura;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "tipus" => $this->getTipus(),
            "nom" => $this->getNom(),
            "num_obra_seguiment" => $this->getNumObraSeguiment(),
            "estat" => $this->isEstat(),
            "pseudonim_client" => $this->getPseudonimClient()?->getId(),
            "portada" => $this->getPortada(),
            "url_arxiu" => $this->getUrlArxiu()?->getId(),
            "factura" => $this->getFactura()?->getId(),
        ];
    }
}
