<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Video;
use App\Manager\VideoManager;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class VideoController extends AbstractController
{
    /**
     * @Route("/video", name="video")
     */
    public function index(VideoManager $videoManager)
    {
        $video = $videoManager->allVideo();
        return $this->render('video/index.html.twig', [
            'video' => $video,
        ]);
    }

    /**
     * @Route("/video/{id}", name="video_id")
     */
    public function id(VideoManager $videoManager, int $id)
    {
        $video = $videoManager->findById($id);
        return $this->render('video/video.html.twig', [
            'video' => $video,
        ]);
    }
    public function category(VideoManager $videoManager, category $category)
    {
        $video = $videoManager->findById($id);
        return $this->render('video/video.html.twig', [
            'video' => $video,
        ]);
    }
}
