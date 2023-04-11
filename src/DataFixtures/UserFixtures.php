<?php

namespace App\DataFixtures;


use App\Entity\User;
use Faker\Factory as Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->passwordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker::create('fr_FR');

        $username = $faker->firstName();
        
        $user = new User();
        $user
            ->setEmail('admin@email.com')
            ->setUsername($username)
            ->setRoles(['ROLE_ADMIN'])
        ;
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'admin');
        $user->setPassword($hashedPassword);
        
        $manager->persist($user);

        for ($i=0; $i < 100; $i++) {
            ;
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setUsername($faker->firstName())
                ->setRoles(['ROLE_USER'])

            ;
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
