<?php

namespace App\Controller;

use App\Manager\VideoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(VideoManager $videoManager)
    {
        $video= $videoManager->videoPublished();
        return $this->render('home/index.html.twig', [
            'video' => $video,
        ]);
    }
}
