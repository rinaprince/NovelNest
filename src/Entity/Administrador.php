<?php

namespace App\Entity;

use App\Repository\AdministradorRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: AdministradorRepository::class)]
class Administrador extends User implements JsonSerializable
{
    // Hereta d'Usuari
}
