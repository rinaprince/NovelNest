<?php

namespace App\Entity;

use App\Repository\AdministradorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministradorRepository::class)]
class Administrador extends User
{
    // Hereta d'Usuari
}
