<?php

namespace App\DataFixtures;

use App\Entity\Arxiu;
use App\Entity\Obra;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArxiuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        //5 archius
        for ($i = 0; $i < 5; $i++) {
            $arxiu = new Arxiu();
            $arxiu->setArxiuPdf($faker->filePath);
            $arxiu->setArxiuPortada($faker->imageUrl(640, 480, 'business'));

            $obra = $this->getReference('obra_' . $i);
            $arxiu->addNumObra($obra);

            $manager->persist($arxiu);
        }

        $manager->flush();
    }
}
