<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User implements \JsonSerializable
{
    #[ORM\Column(length: 50)]
    private ?string $telef = null;

    #[ORM\Column(length: 255)]
    private ?string $direccio = null;

    #[ORM\Column(length: 255)]
    private ?string $num_tarj = null;

    #[ORM\ManyToOne(inversedBy: 'autor')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Factura $id_Factura = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $pseudonim = null;

    #[ORM\OneToMany(targetEntity: Obra::class, mappedBy: 'pseudonim_client')]
    private Collection $obres;

    public function __construct()
    {
        $this->obres = new ArrayCollection();
    }

    public function getTelef(): ?string
    {
        return $this->telef;
    }

    public function setTelef(string $telef): static
    {
        $this->telef = $telef;
        return $this;
    }

    public function getDireccio(): ?string
    {
        return $this->direccio;
    }

    public function setDireccio(string $direccio): static
    {
        $this->direccio = $direccio;
        return $this;
    }

    public function getNumTarj(): ?string
    {
        return $this->num_tarj;
    }

    public function setNumTarj(string $num_tarj): static
    {
        $this->num_tarj = $num_tarj;
        return $this;
    }

    public function getIdFactura(): ?Factura
    {
        return $this->id_Factura;
    }

    public function setIdFactura(?Factura $id_Factura): static
    {
        $this->id_Factura = $id_Factura;
        return $this;
    }

    public function getPseudonim(): ?string
    {
        return $this->pseudonim;
    }

    public function setPseudonim(string $pseudonim): static
    {
        $this->pseudonim = $pseudonim;
        return $this;
    }

    public function getObres(): Collection
    {
        return $this->obres;
    }

    public function addObra(Obra $obra): static
    {
        if (!$this->obres->contains($obra)) {
            $this->obres->add($obra);
            $obra->setPseudonimClient($this);
        }

        return $this;
    }

    public function removeObra(Obra $obra): static
    {
        if ($this->obres->removeElement($obra)) {
            if ($obra->getPseudonimClient() === $this) {
                $obra->setPseudonimClient(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "telef" => $this->getTelef(),
            "direccio" => $this->getDireccio(),
            "num_tarj" => $this->getNumTarj(),
            "id_factura" => $this->getIdFactura()?->getId(),
            "pseudonim" => $this->getPseudonim(),
        ];
    }
}
