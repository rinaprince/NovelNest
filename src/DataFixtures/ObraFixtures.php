<?php

namespace App\DataFixtures;

use App\Entity\Obra;
use App\Entity\Client;
use App\Entity\Arxiu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ObraFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Crear algunas obras
        for ($i = 0; $i < 5; $i++) {
            $obra = new Obra();
            $obra->setTipus($faker->word());
            $obra->setNom($faker->company());
            $obra->setNumObraSeguiment($faker->numberBetween(1, 1000));
            $obra->setEstat($faker->boolean());

            //referència
            $this->addReference('obra_' . $i, $obra);

            //referència a un client
            $client = $this->getReference('client_' . $i);
            $obra->setPseudonimClient($client);

            //referència a un arxiu
            $arxiu = $this->getReference('arxiu_' . $i);
            $obra->setUrlArxiu($arxiu);

            $manager->persist($obra);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

