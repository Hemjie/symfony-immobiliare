<?php

namespace App\DataFixtures;

use App\Entity\RealEstate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 100; $i++) {
            $realEstate = new RealEstate();
            $realEstate->setTitle('Un appartement fixtures');
            $realEstate->setDescription('Une description');
            $realEstate->setSurface(50);
            $realEstate->setPrice(100000);
            $realEstate->setRooms(4);
            $realEstate->setType('appartement');
            $realEstate->setSold(false);

            $manager->persist($realEstate); // On a crée une annonce
        }

        $manager->flush();
    }
}
