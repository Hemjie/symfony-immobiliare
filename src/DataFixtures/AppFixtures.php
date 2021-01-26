<?php

namespace App\DataFixtures;

use App\Entity\RealEstate;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;
    private $passwordEncoder;

    /**
     * Dans une classe d'un projet Symfony, on peut récupérer n'importe quel service via le constructeur
     */
    public function __construct(SluggerInterface $slugger, UserPasswordEncoderInterface $passwordEncoder) {
        $this->slugger = $slugger;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // On crée une instance de Faker pour générer la donnée aléatoire
        $faker = Factory::create('fr_FR');

        //On crée un user pour pouvoir se connecter
        $user = new User();
        $user->setEmail('matthieu@boxydev.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
        $user->setRoles(['ROLE_ADMIN']); //Bien indiquer un tableau, le rôle commence tjs avec ROLE_
        $this->addReference('user-0', $user);
        $manager->persist($user);

        //Créations d'utilisateurs lamdbas
        for ($i = 1; $i <= 9; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'test'));
            $this->addReference('user-'.$i, $user);
            $manager->persist($user);
        }

        // On crée des catégories avant de créer des annonces
        $typeNames = ['Maison', 'Appartement', 'Villa', 'Garage', 'Studio'];
        foreach($typeNames as $key => $typeName) {
            $type = new Type();
            $type->setName($typeName);
            $this->addReference('type-'.$key, $type); //['type-0' => $type]
            $manager->persist($type);
        }

        for ($i = 1; $i <= 100; $i++) {
            $realEstate = new RealEstate();
            $type = $this->getReference('type-'.rand(0, (count($typeNames) - 1) )); //On prend une catégorie aléatoire
            $title = ucfirst($type->getName()).' '; // Appartement ou Maison
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
            $realEstate->setOwner($this->getReference('user-'.rand(0, 9))); //user-0 c'est l'admin
            $manager->persist($realEstate); // On a crée une annonce
        }

        $manager->flush();
    }
}
