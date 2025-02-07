<?php

namespace App\Entity;

use App\Repository\TreballadorRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: TreballadorRepository::class)]
class Treballador extends User implements JsonSerializable
{
    // Hereta d'Usuari
}
