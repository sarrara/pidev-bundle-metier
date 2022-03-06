<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->render('back.html.twig', []);
    }
    /**
     * @Route("/test2", name="test2")
     */
    public function affiche(): Response
    {
        return $this->render('base.html.twig', []);
    }
    /**
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {
        return $this->render('blog.html.twig', []);
    }
}

