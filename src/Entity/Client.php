<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
    #[ORM\Column(length: 50)]
    private ?string $pseudonim = null;

    #[ORM\Column(length: 50)]
    private ?string $telef = null;

    #[ORM\Column(length: 255)]
    private ?string $direccio = null;

    #[ORM\Column(length: 255)]
    private ?string $num_tarj = null;

    public function getPseudonim(): ?string
    {
        return $this->pseudonim;
    }

    public function setPseudonim(string $pseudonim): static
    {
        $this->pseudonim = $pseudonim;

        return $this;
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
}
