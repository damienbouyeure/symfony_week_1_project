<?php


namespace App\Manager;


use App\Entity\Category;
use App\Repository\VideoRepository;

class VideoManager
{

    private $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }
    public function videoPublished()
    {
        return $this->videoRepository->findBy(['published' => true]);
    }

    public function findByCategory(Category $category)
    {
        return $this->videoRepository->findBy(['categories' => $category]);
    }
    public function findById(int $id)
    {
        return $this->videoRepository->findOneBy(['id' => $id]);
    }
    public function allVideo()
    {
        return $this->videoRepository->findAll();
    }



}