<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $haser)
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User;
        $user->setEmail('ejemplo@ejemplo.com');
        $haserPassword = $this->haser->hashPassword($user, 'hola');
        $user->setPassword($haserPassword);
        $manager->persist($user);
        $manager->flush();
    }
}
