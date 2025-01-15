<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $company = new Company();
        $company->setName('Entreprise de Test');
        $company->setEmail('entreprise@test.com');
        $company->setPassword('motdepasse');
        $manager->persist($company);

        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setName("Utilisateur $i");
            $user->setEmail("utilisateur$i@test.com");
            $user->setCompany($company);
            $manager->persist($user);
        }

        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setName("Produit $i");
            $product->setDescription("Description du produit $i");
            $product->setPrice(mt_rand(100, 1000));
            $manager->persist($product);
        }

        $manager->flush();
    }
}