<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("", name="user_")
 */

class UserController extends AbstractController
{

    /**
     *
     * @Route("/inscription", name="register")
     * @return Response
     */
    public function register(): Response
    {

        return $this->render('user/register.html.twig');

    }

}