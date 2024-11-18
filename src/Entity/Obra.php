<?php

namespace App\Entity;

use App\Repository\ObraRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObraRepository::class)]
class Obra
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $tipus = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudonim_Client = null;

    #[ORM\Column(length: 50)]
    private ?string $id_Arxiu = null;

    #[ORM\Column]
    private ?int $numObra_seguiment = null;

    #[ORM\Column]
    private ?int $id_Factura = null;

    #[ORM\Column]
    private ?bool $estat = null;

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

    public function setTipus(string $tipus): static
    {
        $this->tipus = $tipus;

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

    public function getPseudonimClient(): ?string
    {
        return $this->pseudonim_Client;
    }

    public function setPseudonimClient(string $pseudonim_Client): static
    {
        $this->pseudonim_Client = $pseudonim_Client;

        return $this;
    }

    public function getIdArxiu(): ?string
    {
        return $this->id_Arxiu;
    }

    public function setIdArxiu(string $id_Arxiu): static
    {
        $this->id_Arxiu = $id_Arxiu;

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

    public function getIdFactura(): ?int
    {
        return $this->id_Factura;
    }

    public function setIdFactura(int $id_Factura): static
    {
        $this->id_Factura = $id_Factura;

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
}
