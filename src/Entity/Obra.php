<?php

namespace App\Entity;

use App\Repository\ObraRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: ObraRepository::class)]
class Obra implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El tipus no puede estar vacío.")]
    #[Assert\Length(max: 50, maxMessage: "El tipus no puede tener más de {{ limit }} caracteres.")]
    private ?string $tipus = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "El nom no puede estar vacío.")]
    #[Assert\Length(max: 50, maxMessage: "El nom no puede tener más de {{ limit }} caracteres.")]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "El número de seguimiento no puede ser nulo.")]
    #[Assert\Positive(message: "El número de seguimiento debe ser positivo.")]
    private ?int $num_obra_seguiment = null;

    #[ORM\Column]
    #[Assert\NotNull(message: "El estado no puede ser nulo.")]
    private ?bool $estat = null;

    #[ORM\ManyToOne(inversedBy: 'obres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "El cliente es obligatorio.")]
    private ?Client $client = null;

    #[ORM\Column(length: 255)]
    #[Assert\Url(message: "La portada debe ser una URL válida.")]
    private ?string $portada = null;

    #[Vich\UploadableField(mapping: 'obres', fileNameProperty: 'portada')]
    #[Assert\Image(
        //maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/gif'],
        mimeTypesMessage: 'Puja estos formats: jpeg, png, gif.'
    )]
    private ?File $portadaFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'num_Obra')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(message: "El archivo URL es obligatorio.")]
    private ?Arxiu $url_arxiu = null;

    #[ORM\ManyToOne(inversedBy: 'obres')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Factura $factura = null;

    #[ORM\Column(type: 'float')]
    private float $preu;

    public function getPreu(): ?float
    {
        return $this->preu;
    }

    public function setPreu(float $precio): self
    {
        $this->preu = $precio;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipus(): ?string
    {
        return $this->tipus;
    }

    public function setTipus(?string $tipus): static
    {
        $this->tipus = $tipus;
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNumObraSeguiment(): ?int
    {
        return $this->num_obra_seguiment;
    }

    public function setNumObraSeguiment(?int $num_obra_seguiment): static
    {
        $this->num_obra_seguiment = $num_obra_seguiment;
        return $this;
    }

    public function isEstat(): ?bool
    {
        return $this->estat;
    }

    public function setEstat(?bool $estat): static
    {
        $this->estat = $estat;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;
        return $this;
    }

    public function getPortada(): ?string
    {
        return $this->portada;
    }

    public function setPortada(?string $portada): static
    {
        $this->portada = $portada;
        return $this;
    }

    public function getPortadaFile(): ?File
    {
        return $this->portadaFile;
    }

    public function setPortadaFile(?File $portadaFile = null): void
    {
        $this->portadaFile = $portadaFile;
        if (null !== $portadaFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
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

    public function getPdfPath(): ?string
    {
        if ($this->url_arxiu && $this->url_arxiu->getArxiuPdf()) {
            $filename = basename($this->url_arxiu->getArxiuPdf());
            return '/uploads/pdf/' . $filename;
        }
        return null;
    }

    public function __toString(): string
    {
        return $this->nom ?? 'Nueva Obra';
    }

    public function getFactura(): ?Factura
    {
        return $this->factura;
    }

    public function setFactura(?Factura $factura): static
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
            "client" => $this->getClient()?->getId(),
            "portada" => $this->getPortada(),
            "url_arxiu" => $this->getUrlArxiu()?->getId(),
            "factura" => $this->getFactura()?->getId(),
            "preu" => $this->getPreu(),
        ];
    }
}
