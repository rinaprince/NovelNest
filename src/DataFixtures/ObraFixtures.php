<?php

namespace App\DataFixtures;

use App\Entity\Obra;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ObraFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Crear 5 obres
        for ($i = 0; $i < 5; $i++) {
            $obra = new Obra();
            $obra->setTipus($faker->word());
            $obra->setNom($faker->company());
            $obra->setNumObraSeguiment($faker->numberBetween(1, 1000));
            $obra->setEstat($faker->boolean());

            // Referència a un client
            $client = $this->getReference('client_' . $i);
            $obra->setPseudonimClient($client);

            // Referència a un arxiu
            $arxiu = $this->getReference('arxiu_' . $i);
            $obra->setUrlArxiu($arxiu);

            $this->addReference('obra_' . $i, $obra);

            $manager->persist($obra);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ArxiuFixtures::class,
        ];
    }
}

