<?php

namespace App\Entity;

use App\Repository\FacturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturaRepository::class)]
class Factura implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $preu = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    /**
     * @var Collection<int, Client>
     */
    #[ORM\OneToMany(targetEntity: Client::class, mappedBy: 'id_Factura')]
    private Collection $autor;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Obra $num_FacturaSeg = null;

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

    public function getNumFacturaSeg(): ?Obra
    {
        return $this->num_FacturaSeg;
    }

    public function setNumFacturaSeg(Obra $num_FacturaSeg): static
    {
        $this->num_FacturaSeg = $num_FacturaSeg;

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "preu" => $this->getPreu(),
            "data" => $this->getData()?->format('d/m/Y'),
            "autor" => $this->getAutor()->map(fn($autor) => $autor->jsonSerialize())->toArray(),
            "num_FacturaSeg" => $this->getNumFacturaSeg(),
        ];
    }
}
