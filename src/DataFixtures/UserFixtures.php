<?php

namespace App\DataFixtures;

use App\Entity\Administrador;
use App\Entity\Factura;
use App\Entity\Treballador;
use App\Entity\Client;
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

        //rol ADMIN
        $admin = new Administrador();
        $admin->setNomUsuari('admin');
        $admin->setContrasenya(
            $this->passwordHasher->hashPassword($admin, 'admin')
        );
        $admin->setNom($faker->firstName());
        $admin->setCognom($faker->lastName());
        $admin->setCorreu($faker->email());
        $admin->setRols(['ROLE_ADMIN']);
        $manager->persist($admin);

        //rol TREBALLADOR
        $treballador = new Treballador();
        $treballador->setNomUsuari('treballador');
        $treballador->setContrasenya(
            $this->passwordHasher->hashPassword($treballador, 'treballador')
        );
        $treballador->setNom($faker->firstName());
        $treballador->setCognom($faker->lastName());
        $treballador->setCorreu($faker->email());
        $treballador->setRols(['ROLE_TREBALLADOR']);
        $manager->persist($treballador);

        //rol CLIENT
        for ($i = 0; $i < 5; $i++) {
            $client = new Client();
            $client->setNomUsuari('client');
            $client->setContrasenya(
                $this->passwordHasher->hashPassword($client, 'client')
            );
            $client->setNom($faker->firstName());
            $client->setCognom($faker->lastName());
            $client->setCorreu($faker->email());
            $client->setRols(['ROLE_CLIENT']);
            $client->setTelef($faker->phoneNumber());
            $client->setDireccio($faker->address());
            $client->setNumTarj($faker->creditCardNumber());
            $manager->persist($client);

            //Referència
            $this->addReference('client_' . $i, $client);
        }
        $manager->flush();
    }
}