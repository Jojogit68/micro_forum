<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Topic;
use App\Repository\TopicRepository;
use Faker\Factory as Faker;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    protected UserRepository $userRepository;
    protected TopicRepository $topicRepository;

    public function __construct(UserRepository $userRepository, TopicRepository $topicRepository)
    {
        $this->userRepository = $userRepository;
        $this->topicRepository = $topicRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create('fr_FR');
        $users = $this->userRepository->findAll();
        $topics = $this->topicRepository->findAll();
        $usersLength = count($users)-1;
        $topicsLength = count($topics)-1;
        for ($i=0; $i < 10000; $i++) {
            // permet d'avoir un utilisateur random
            // possible à faire avec Faker mais plus lourd en ressource
            $randomKey = rand(0, $usersLength);
            $user = $users[$randomKey];
            $randomKeyTopic = rand(0, $topicsLength);
            $topic = $topics[$randomKeyTopic];
            $comment = new Comment();
            $topic
                ->setContent($faker->sentences(3, true))
                ->setAuthor($user)
            ;
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TopicFixtures::class,
        ];
    }
}