<?php

namespace App\DataFixtures;

use App\Entity\Contrat;
use App\Entity\ContratType;
use App\Entity\Offres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CreateData extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        $allContrats = array();
        $allTypes = array();

        foreach (array("CDI", "CDD", "FREE") as &$val) {
            $contrat = new Contrat();
            $contrat->setContratType($val);
            array_push($allContrats, $contrat);
            $manager->persist($contrat);
        }
        foreach (array("Temps plein", "Temps partiel") as &$val) {
            $contratType = new ContratType();
            $contratType->setTitle($val);
            array_push($allTypes, $contratType);
            $manager->persist($contratType);
        }
        for ($i = 1; $i <= 50; $i++) {
            $contratIndex = rand(0, sizeof($allContrats) - 1);
            $contrat = $allContrats[$contratIndex];

            $offre = new Offres();
            $offre->setTitle($faker->jobTitle)
                ->setDescription($faker->text)
                ->setAdresse($faker->streetAddress)
                ->setCodePostal($faker->postcode)
                ->setVille($faker->city)
                ->setDateCreation($faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null))
                ->setUpdateDate($faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null))
                ->setContratType($allTypes[rand(0, sizeof($allTypes) - 1)])
                ->setContrat($contrat);

            if ($contratIndex >= 1 and $contratIndex <= 2) {
                $offre->setFinMission($faker->dateTimeBetween($startDate = 'now', $endDate = '+1 years', $timezone = null));
            }
            $manager->persist($offre);
        }


        $manager->flush();
    }
}
