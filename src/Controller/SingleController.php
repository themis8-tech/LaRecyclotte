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
    public function concept(): Response
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
     * @Route("/mentions_légales", name="mentions_legales")
     */
    public function mentions(): Response
    {
        return $this->render('single/mentions_legales.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu(): Response
    {
        return $this->render('single/CGU.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }

    /**
     * @Route("/plan", name="plan_du_site")
     */
    public function plan(): Response
    {
        return $this->render('single/plan_site.html.twig', [
            'controller_name' => 'SingleController',
        ]);
    }
}
