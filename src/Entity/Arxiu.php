<?php

namespace App\Entity;

use App\Repository\ArxiuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArxiuRepository::class)]
class Arxiu implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $arxiu_pdf = null;

    #[ORM\Column(length: 255)]
    private ?string $arxiu_portada = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_original = null;

    #[ORM\OneToMany(mappedBy: 'url_arxiu', targetEntity: Obra::class)]
    private Collection $num_Obra;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $paginas;

    public function getPaginas(): ?int
    {
        return $this->paginas;
    }

    public function setPaginas(?int $paginas): self
    {
        $this->paginas = $paginas;
        return $this;
    }

    public function __construct()
    {
        $this->num_Obra = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArxiuPdf(): ?string
    {
        return $this->arxiu_pdf;
    }

    public function setArxiuPdf(string $arxiu_pdf): static
    {
        $this->arxiu_pdf = $arxiu_pdf;
        return $this;
    }

    public function getArxiuPortada(): ?string
    {
        return $this->arxiu_portada;
    }

    public function setArxiuPortada(string $arxiu_portada): static
    {
        $this->arxiu_portada = $arxiu_portada;
        return $this;
    }

    public function getNomOriginal(): ?string
    {
        return $this->nom_original;
    }

    public function setNomOriginal(?string $nom_original): static
    {
        $this->nom_original = $nom_original;
        return $this;
    }

    /**
     * @return Collection<int, Obra>
     */
    public function getNumObra(): Collection
    {
        return $this->num_Obra;
    }

    public function addNumObra(Obra $numObra): static
    {
        if (!$this->num_Obra->contains($numObra)) {
            $this->num_Obra->add($numObra);
            $numObra->setUrlArxiu($this);
        }
        return $this;
    }

    public function removeNumObra(Obra $numObra): static
    {
        if ($this->num_Obra->removeElement($numObra)) {
            if ($numObra->getUrlArxiu() === $this) {
                $numObra->setUrlArxiu(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom_original ?? $this->arxiu_pdf ?? 'Archivo sin nombre';
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->getId(),
            "arxiu_pdf" => $this->getArxiuPdf(),
            "arxiu_portada" => $this->getArxiuPortada(),
            "nom_original" => $this->getNomOriginal(),
            "num_obra" => $this->getNumObra()->toArray()
        ];
    }
}
