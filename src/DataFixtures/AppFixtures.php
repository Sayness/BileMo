<?php

namespace App\DataFixtures;

use App\Entity\Company;
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
        // Créer une entreprise
        $company = new Company();
        $company->setName('Test Company');
        $company->setEmail('company@example.com');
        $company->setPassword('password');
        $manager->persist($company);

        // Ajouter un utilisateur lié à l'entreprise
        $user = new User();
        $user->setName('Test User');
        $user->setEmail('user@example.com');
        $user->setCompany($company);
        $manager->persist($user);

        // Sauvegarder les données
        $manager->flush();
    }
}
