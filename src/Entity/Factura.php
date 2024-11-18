<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $num_Factura = null;

    #[ORM\Column(length: 255)]
    private ?string $preu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    /**
     * @var Collection<int, Client>
     */
    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'id_Factura')]
    private Collection $autor;

    public function __construct()
    {
        $this->autor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNumFactura(): ?int
    {
        return $this->num_Factura;
    }

    public function setNumFactura(int $num_Factura): static
    {
        $this->num_Factura = $num_Factura;

        return $this;
    }

    public function getPreu(): ?string
    {
        return $this->preu;
    }

    public function setPreu(string $preu): static
    {
        $this->preu = $preu;

        return $this;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return Collection<int, Client>
     */
    public function getAutor(): Collection
    {
        return $this->autor;
    }

    public function addAutor(Client $autor): static
    {
        if (!$this->autor->contains($autor)) {
            $this->autor->add($autor);
            $autor->setIdFactura($this);
        }

        return $this;
    }

    public function removeAutor(Client $autor): static
    {
        if ($this->autor->removeElement($autor)) {
            // set the owning side to null (unless already changed)
            if ($autor->getIdFactura() === $this) {
                $autor->setIdFactura(null);
            }
        }

        return $this;
    }
}
