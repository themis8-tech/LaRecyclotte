<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SingleController extends AbstractController
{
    /**
     * @Route("/concept", name="concept")
     */
    public function index(): Response
    {
        return $this->render('single/concept.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(): Response
    {
        return $this->render('single/faq.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }

    /**
     * @Route("/mentions_légales", name="mentions_légales")
     */
    public function mentions(): Response
    {
        return $this->render('single/mentions.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu(): Response
    {
        return $this->render('single/cgu.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }

    /**
     * @Route("/plan", name="plan")
     */
    public function plan(): Response
    {
        return $this->render('single/plan.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }
    
}
