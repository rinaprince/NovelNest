<?php

namespace App\DataFixtures;

use App\Entity\Factura;
use App\Entity\Obra;
use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FacturaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $factura = new Factura();
            $factura->setPreu($faker->randomNumber(2));
            $factura->setData($faker->dateTimeThisYear());

            //Fent referència als clients en UserFixtures
            $client = $this->getReference('client_' . $i);
            $factura->addAutor($client);


            $manager->persist($factura);
        }

        $manager->flush();
    }
}
