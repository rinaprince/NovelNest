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

    #[ORM\OneToMany(mappedBy: 'url_arxiu', targetEntity: Obra::class)]
    private Collection $num_Obra;

    public function __construct()
    {
        $this->num_Obra = new ArrayCollection();
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
            // set the owning side to null (unless already changed)
            if ($numObra->getUrlArxiu() === $this) {
                $numObra->setUrlArxiu(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return ["id" => $this->getId(),
            "arxiu_pdf"=> $this->getArxiuPdf(),
            "arxiu_portada" => $this->getArxiuPortada(),
            "num_obra" => $this->getNumObra()];
    }
}
