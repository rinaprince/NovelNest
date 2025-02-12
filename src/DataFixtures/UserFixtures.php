<?php

namespace App\DataFixtures;

use App\Entity\Administrador;
use App\Entity\Treballador;
use App\Entity\Client;
use App\Entity\Factura;
use App\Entity\Obra;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // 1 Administrador
        $admin = new Administrador();
        $admin->setNomUsuari('admin');
        $admin->setContrasenya($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setNom($faker->firstName());
        $admin->setCognom($faker->lastName());
        $admin->setCorreu($faker->email());
        $admin->setRols(['ROLE_ADMIN']);
        $manager->persist($admin);

        // 1 Treballador
        $treballador = new Treballador();
        $treballador->setNomUsuari('treballador');
        $treballador->setContrasenya($this->passwordHasher->hashPassword($treballador, 'treballador'));
        $treballador->setNom($faker->firstName());
        $treballador->setCognom($faker->lastName());
        $treballador->setCorreu($faker->email());
        $treballador->setRols(['ROLE_TREBALLADOR']);
        $manager->persist($treballador);

        // 5 Clients amb Factura i Obra
        for ($i = 0; $i < 5; $i++) {
            $client = new Client();

            // Tipus comú per obra i factura
            $tipus = $faker->randomElement(['Relato corto', 'Poesía', 'Novela']);

            if ($i == 0) {
                $client->setNomUsuari('client');
                $client->setPseudonim('Rina Prince');
                $client->setContrasenya($this->passwordHasher->hashPassword($client, 'client'));
            } else {
                $client->setNomUsuari($faker->userName());
                $client->setPseudonim($faker->userName());
                $client->setContrasenya($this->passwordHasher->hashPassword($client, 'client' . ($i + 1)));
            }

            $client->setNom($faker->firstName());
            $client->setCognom($faker->lastName());
            $client->setCorreu($faker->email());
            $client->setRols(['ROLE_CLIENT']);
            $client->setTelef($faker->phoneNumber());
            $client->setDireccio($faker->address());
            $client->setNumTarj($faker->creditCardNumber());

            $manager->persist($client);

            // Crear entre 1 i 3 obres per a cada client
            $numObras = rand(1, 3);
            for ($j = 0; $j < $numObras; $j++) {
                // Crear factura per a cada obra
                $factura = new Factura();
                $factura->setTipus($tipus);
                $factura->setNumFactura($faker->unique()->numerify('FAC###'));
                $factura->setPreu($faker->randomFloat(2, 10, 1000));
                $factura->setQuantitat($faker->numberBetween(1, 100));
                $factura->setClient($client);
                $client->setIdFactura($factura);
                $manager->persist($factura);

                // Crear obra associada a la factura
                $obra = new Obra();
                $obra->setTipus($tipus);
                $obra->setNom($faker->sentence(3));
                $obra->setNumObraSeguiment($faker->unique()->numberBetween(1000, 9999));
                $obra->setEstat($faker->boolean());
                $obra->setPseudonimClient($client->getPseudonim());
                $obra->setPortada($faker->imageUrl());
                $obra->setFactura($factura);
                $obra->setClient($client);

                // Afegir referència a un arxiu fictici si és necessari
                if ($this->hasReference('arxiu_' . $j)) {
                    $obra->setUrlArxiu($this->getReference('arxiu_' . $j));
                }

                $manager->persist($obra);
            }
        }

        $manager->flush();
    }
}