<?php

namespace App\DataFixtures;

use App\Entity\Factura;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FacturaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Crear 5 factures
        for ($i = 0; $i < 5; $i++) {
            $factura = new Factura();
            $factura->setPreu($faker->randomFloat(2, 100, 1000));
            $factura->setData($faker->dateTimeThisYear());

            //referència a un client
            $client = $this->getReference('client_' . $i);
            $factura->setId($client);

            // Referència a una obra
            $obra = $this->getReference('obra_' . $i);
            $factura->setNumFacturaSeg($obra);

            $this->addReference('factura_' . $i, $factura);

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