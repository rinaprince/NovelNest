<?php

namespace App\DataFixtures;

use App\Entity\Arxiu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArxiuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //5 arxius
        for ($i = 0; $i < 5; $i++) {
            $arxiu = new Arxiu();
            $arxiu->setArxiuPdf($faker->filePath());
            $arxiu->setArxiuPortada($faker->imageUrl(640, 480, 'business'));

            //referència propia
            $this->addReference('arxiu_' . $i, $arxiu);
            $manager->persist($arxiu);
        }

        $manager->flush();
    }
}