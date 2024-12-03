<?php

namespace App\DataFixtures;

use App\Entity\Administrador;
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

        // Crear usuario con rol ADMIN
        $admin = new Administrador();
        $admin->setNomUsuari('admin')
            ->setContrasenya(
                $this->passwordHasher->hashPassword($admin, 'adminpass')
            )
            ->setNom($faker->firstName())
            ->setCognom($faker->lastName())
            ->setCorreu($faker->email())
            ->setRols(['ROLE_ADMIN']);
        $manager->persist($admin);

        // Crear usuario con rol TREBALLADOR
        $worker = new Treballador();
        $worker->setNomUsuari('treballador')
            ->setContrasenya(
                $this->passwordHasher->hashPassword($worker, 'workerpass')
            )
            ->setNom($faker->firstName())
            ->setCognom($faker->lastName())
            ->setCorreu($faker->email())
            ->setRols(['ROLE_TREBALLADOR']);
        $manager->persist($worker);

        // Crear usuario con rol CLIENT
        $client = new Client();
        $client->setNomUsuari('client')
            ->setContrasenya(
                $this->passwordHasher->hashPassword($client, 'clientpass')
            )
            ->setNom($faker->firstName())
            ->setCognom($faker->lastName())
            ->setCorreu($faker->email())
            ->setRols(['ROLE_CLIENT'])
            ->setTelef($faker->phoneNumber())
            ->setDireccio($faker->address())
            ->setNumTarj($faker->creditCardNumber());
        $manager->persist($client);

        $manager->flush();
    }
}