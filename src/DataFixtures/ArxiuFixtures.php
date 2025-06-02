<?php

namespace App\DataFixtures;

use App\Entity\Arxiu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Mpdf\Mpdf;

class ArxiuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Asegúrate de que la carpeta exista
        $pdfDir = __DIR__ . '/../../public/uploads/pdf';
        $coverDir = __DIR__ . '/../../public/uploads/portades';

        if (!is_dir($pdfDir)) {
            mkdir($pdfDir, 0777, true);
        }
        if (!is_dir($coverDir)) {
            mkdir($coverDir, 0777, true);
        }

        for ($i = 0; $i < 5; $i++) {
            // Crear PDF con mpdf
            $pdfFilename = 'sample' . $i . '.pdf';
            $pdfPath = $pdfDir . '/' . $pdfFilename;

            $mpdf = new Mpdf();
            $mpdf->WriteHTML('<h1>' . $faker->sentence() . '</h1><p>' . $faker->paragraph(3) . '</p>');
            $mpdf->Output($pdfPath, \Mpdf\Output\Destination::FILE);

            // Crear Arxiu entidad
            $arxiu = new Arxiu();
            $arxiu->setArxiuPdf($pdfFilename);
            $arxiu->setArxiuPortada('uploads/portades/portada' . $i . '.jpg');

            $this->addReference('arxiu_' . $i, $arxiu);
            $manager->persist($arxiu);
        }

        $manager->flush();
    }
}