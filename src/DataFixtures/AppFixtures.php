<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Customer;
use App\Entity\Product;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
   

    public function load(ObjectManager $manager): void
    {
        
        $customer= new Customer();
        $customer->setFirstname('Gustavo')
             ->setLastname('Frings')
            ->setEmail('gustavo@test.com')
            ->setCompany('Free')
            ->setRoles(array('ROLE_USER'))
            ->setPassword($this->hasher->hashPassword($customer, 'test'));

        $manager->persist($customer);


        $customer2= new Customer();


        $customer2->setFirstname('Ragnar')
             ->setLastname('Lothbrock')
            ->setEmail('ragnar@test.com')
            ->setCompany('Vodafone')
            ->setRoles(array('ROLE_USER'))
            ->setPassword($this->hasher->hashPassword($customer2, 'test'));

        $manager->persist($customer2);


        $customer3= new Customer();


        $customer3->setFirstname('Logan')
             ->setLastname('Wolverine')
            ->setEmail('logan@test.com')
            ->setCompany('SFR')
            ->setRoles(array('ROLE_USER'))
            ->setPassword($this->hasher->hashPassword($customer3, 'test'));

        $manager->persist($customer3);



        $manager->flush();
        $faker = Factory::create('eng_ENG');

        for ($i = 0; $i < 12; ++$i) {
            $user = new User();
            $user->setFirstname($faker->name())
                 ->setLastname($faker->name())
                ->setEmail($faker->email())
                ->setRoles(array('ROLE_USER'))
                ->setPassword($this->hasher->hashPassword($user, 'test'))
                ->setCustomer($customer);
            $manager->persist($user); 
        }
        for ($i = 0; $i < 3; ++$i) {
            $user = new User();
            $user->setFirstname($faker->name())
                 ->setLastname($faker->name())
                ->setEmail($faker->email())
                ->setRoles(array('ROLE_USER'))
                ->setPassword($this->hasher->hashPassword($user, 'test'))
                ->setCustomer($customer2);
            $manager->persist($user);
        }
        for ($i = 0; $i < 9; ++$i) {
            $user = new User();
            $user->setFirstname($faker->firstname())
                 ->setLastname($faker->lastname())
                ->setEmail($faker->email())
                ->setRoles(array('ROLE_USER'))
                ->setPassword($this->hasher->hashPassword($user, 'test'))
                ->setCustomer($customer3);
            $manager->persist($user);
        }

        $product = new Product();
        $product->setName("Iphone X")
                ->setDescription("Système d'exploitation: iOS
                Taille d'écran: Écran 6,1 po
                Fonctions de sécurité: Reconnaissance faciale, Lecteur d'empreintes digitales")
                ->setPrice(899.99)
                ->setCreatedAt(new DateTime());
                $manager->persist($product);


                
        $product2 = new Product();
        $product2->setName("Samsung S20")
                ->setDescription("Marque: Samsung
                Système d'exploitation: Android
                Taille d'écran: Écran 6,2 po")
                ->setPrice(1000.99)
                ->setCreatedAt(new DateTime());
                $manager->persist($product2);

                $product3 = new Product();
                $product3->setName("Samsung S22")
                        ->setDescription("Marque
                        Samsung
                        Système d'exploitation
                        Android
                        Taille d'écran
                        Écran 6,8 po
                        Fonctions de sécurité
                        Reconnaissance faciale, Lecteur d'empreintes digitales
                        Résolution de la caméra face avant
                        Résolution de la caméra avant: 40 MP
                        Résolution de l'appareil photo face arrière
                        Résolution de l'appareil photo arrière: 12 MP")
                        ->setPrice(1300.99)
                        ->setCreatedAt(new DateTime());
                        $manager->persist($product2);

        $manager->flush(); 
}

}
