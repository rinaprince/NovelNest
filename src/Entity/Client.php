<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User implements \JsonSerializable
{
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'El teléfono no puede estar vacío.')]
    #[Assert\Regex(
        pattern: '/^\+?\d{7,15}$/',
        message: 'El número de teléfono debe ser válido (entre 7 y 15 dígitos, opcionalmente con + al inicio).'
    )]
    private ?string $telef = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La dirección no puede estar vacía.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'La dirección no puede tener más de 255 caracteres.'
    )]
    private ?string $direccio = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'El número de tarjeta no puede estar vacío.')]
    #[Assert\Regex(
        pattern: '/^\d{16}$/',
        message: 'El número de tarjeta debe tener exactamente 16 dígitos.'
    )]
    private ?string $num_tarj = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Assert\NotBlank(message: 'El pseudónimo no puede estar vacío.')]
    #[Assert\Length(
        max: 50,
        maxMessage: 'El pseudónimo no puede tener más de 50 caracteres.'
    )]
    private ?string $pseudonim = null;

    #[ORM\OneToMany(targetEntity: Factura::class, mappedBy: 'client')]
    private Collection $factures;

    #[ORM\OneToMany(targetEntity: Obra::class, mappedBy: 'client')]
    private Collection $obres;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
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

    public function getPseudonim(): ?string
    {
        return $this->pseudonim;
    }

    public function setPseudonim(string $pseudonim): static
    {
        $this->pseudonim = $pseudonim;
        return $this;
    }

    /**
     * @return Collection<int, Factura>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFactura(Factura $factura): static
    {
        if (!$this->factures->contains($factura)) {
            $this->factures->add($factura);
            $factura->setClient($this);
        }

        return $this;
    }

    public function removeFactura(Factura $factura): static
    {
        if ($this->factures->removeElement($factura)) {
            if ($factura->getClient() === $this) {
                $factura->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Obra>
     */
    public function getObres(): Collection
    {
        return $this->obres;
    }

    public function addObra(Obra $obra): static
    {
        if (!$this->obres->contains($obra)) {
            $this->obres->add($obra);
            $obra->setClient($this);
        }

        return $this;
    }

    public function removeObra(Obra $obra): static
    {
        if ($this->obres->removeElement($obra)) {
            if ($obra->getClient() === $this) {
                $obra->setClient(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return array_merge(parent::jsonSerialize(), [
            "telef" => $this->getTelef(),
            "direccio" => $this->getDireccio(),
            "num_tarj" => $this->getNumTarj(),
            "pseudonim" => $this->getPseudonim(),
            "factures" => $this->getFactures()->map(fn(Factura $factura) => $factura->getId())->toArray(),
            "obres" => $this->getObres()->map(fn(Obra $obra) => $obra->getId())->toArray(),
        ]);
    }
}
