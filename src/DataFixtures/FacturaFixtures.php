<?php

namespace App\DataFixtures;

use App\Entity\Factura;
use App\Entity\Client;
use App\Entity\Obra;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FacturaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //5 factures
        for ($i = 0; $i < 5; $i++) {
            $factura = new Factura();
            $factura->setPreu($faker->randomFloat(2, 100, 1000));
            $factura->setData($faker->dateTimeThisYear());

            //referència als clients en ClientsFixtures
            $client = $this->getReference('client_' . $i);
            $factura->addAutor($client);

            //referència a obres en ObraFixtures
            $obra = $this->getReference('obra_' . $i);
            $factura->setNumFacturaSeg($obra);

            $manager->persist($factura);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ObraFixtures::class,
        ];
    }
}