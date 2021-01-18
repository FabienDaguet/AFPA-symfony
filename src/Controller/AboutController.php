<?php
// src/Controller/AboutController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{

    /**
     * @Route("/contact", name="page_about", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('page/contact.html.twig');
    }
}    