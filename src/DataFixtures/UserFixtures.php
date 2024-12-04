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

        //1 administrador
        $admin = new Administrador();
        $admin->setNomUsuari('admin');
        $admin->setContrasenya($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setNom($faker->firstName());
        $admin->setCognom($faker->lastName());
        $admin->setCorreu($faker->email());
        $admin->setRols(['ROLE_ADMIN']);
        $manager->persist($admin);

        //1 treballador
        $treballador = new Treballador();
        $treballador->setNomUsuari('treballador');
        $treballador->setContrasenya($this->passwordHasher->hashPassword($treballador, 'treballador'));
        $treballador->setNom($faker->firstName());
        $treballador->setCognom($faker->lastName());
        $treballador->setCorreu($faker->email());
        $treballador->setRols(['ROLE_TREBALLADOR']);
        $manager->persist($treballador);

        //5 clients amb factura i obra cadascún
        for ($i = 0; $i < 5; $i++) {
            //Client
            $client = new Client();
            $client->setNomUsuari('client' . ($i + 1));
            $client->setContrasenya($this->passwordHasher->hashPassword($client, 'client' . ($i + 1)));
            $client->setNom($faker->firstName());
            $client->setCognom($faker->lastName());
            $client->setCorreu($faker->email());
            $client->setRols(['ROLE_CLIENT']);
            $client->setTelef($faker->phoneNumber());
            $client->setDireccio($faker->address());
            $client->setNumTarj($faker->creditCardNumber());

            //Factura
            $factura = new Factura();
            $factura->setPreu($faker->randomFloat(2, 100, 1000));
            $factura->setData($faker->dateTimeThisYear());

            //Obra
            $obra = new Obra();
            $obra->setTipus($faker->word());
            $obra->setNom($faker->sentence(3));
            $obra->setNumObraSeguiment($faker->numberBetween(1000, 9999));
            $obra->setEstat($faker->boolean());
            $obra->setPseudonimClient($client);
            $obra->setPortada($faker->imageUrl());
            $obra->setUrlArxiu(null);

            //1 factura a 1 obra i 1 client
            $factura->setNumFacturaSeg($obra);
            $client->setIdFactura($factura);

            $manager->persist($client);
            $manager->persist($factura);
            $manager->persist($obra);
        }

        $manager->flush();
    }
}