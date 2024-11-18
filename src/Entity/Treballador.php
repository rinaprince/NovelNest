<?php

namespace App\Entity;

use App\Repository\TreballadorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreballadorRepository::class)]
class Treballador extends User
{
    // Hereta d'Usuari
}
