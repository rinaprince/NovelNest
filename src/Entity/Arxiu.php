<?php

namespace App\Entity;

use App\Repository\ArxiuRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArxiuRepository::class)]
class Arxiu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url_Arxiu = null;

    #[ORM\Column]
    private ?int $id_Obra = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUrlArxiu(): ?string
    {
        return $this->url_Arxiu;
    }

    public function setUrlArxiu(string $url_Arxiu): static
    {
        $this->url_Arxiu = $url_Arxiu;

        return $this;
    }

    public function getIdObra(): ?int
    {
        return $this->id_Obra;
    }

    public function setIdObra(int $id_Obra): static
    {
        $this->id_Obra = $id_Obra;

        return $this;
    }
}
