<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Review;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i=0; $i < 25 ; $i++) { 
           $avis = new Review();
           $avis->setName($faker->name());
           $avis->setDatePublication($faker->dateTimeBetween('-7 months'));
           $avis->setMessage($faker->text());
        // la note se régle entre 4 étoiles et 5 étoiles
           $avis->setNote($faker->numberBetween(4,5));
           $manager->persist($avis);
        }
        
        // $manager->persist($product);

        $manager->flush();
    }
}
