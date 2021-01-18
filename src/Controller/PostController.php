<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{

    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(NewsRepository $newsRepository): Response
    {
        //$news = $newsRepository->findAll();
        $lastNews = $newsRepository->findLastNews(10);
        $oldNews = $newsRepository->findOldNews();
        //dd($oldNews);
        return $this->render('post/index.html.twig', [
            "lastNews" => $lastNews,
            "oldNews" => $oldNews,
        ]);
    }


    /**
     * @Route("/view/{id}", name="post_view", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function view(NewsRepository $newsRepository, News $news)
    {
        $oldNews = $newsRepository->findOldNews();
        return $this->render('post/view.html.twig', [
            'news' => $news,
            "oldNews" => $oldNews,
        ]);
    }
} 