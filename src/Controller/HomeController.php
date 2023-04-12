<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', methods:['GET'])]
    public function index(TopicRepository $topicRepository): Response
    {
        $topics = $topicRepository->findBy([], ['id' => 'DESC']);
        return $this->render('home/index.html.twig', [
            'topics' => $topics
        ]);
    }
}
