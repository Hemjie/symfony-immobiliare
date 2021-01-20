<?php

namespace App\DataFixtures;

use App\Entity\RealEstate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    /**
     * Dans une classe d'un projet Symfony, on peut récupérer n'importe quel service via le constructeur
     */
    public function __construct(SluggerInterface $slugger) {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        // On crée une instance de Faker pour générer la donnée aléatoire
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 100; $i++) {
            $realEstate = new RealEstate();
            $type = $faker->randomElement(['maison', 'appartement']);
            $title = ucfirst($type).' '; // Appartement ou Maison
            $rooms = $faker->numberBetween(1, 5);
            $title .= RealEstate::SIZES[$rooms]; //Création de la constante SIZES, on obtient les valeurs Studio, T2...
            // Maison T4 (en centre-ville, en campagne)
            $realEstate->setTitle($title);
            $realEstate->setSlug($this->slugger->slug($title)->lower());
            $realEstate->setDescription($faker->text(2000));
            $realEstate->setSurface($faker->numberBetween(10, 400));
            $realEstate->setPrice($faker->numberBetween(34875, 584725));
            $realEstate->setRooms($faker->numberBetween(1, 5));
            $realEstate->setType($type);
            $realEstate->setSold($faker->boolean(10)); //10 % de chances d'avoir true
            $realEstate->setImage($faker->randomElement(['default.png', 'fixtures/1.jpg', 'fixtures/2.jpg', 'fixtures/3.jpg', 'fixtures/4.jpg']));

            $manager->persist($realEstate); // On a crée une annonce
        }

        $manager->flush();
    }
}
