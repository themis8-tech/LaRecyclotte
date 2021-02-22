<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("", name="user_")
 */

class UserController extends AbstractController
{
    private $em;
    private $repository;

    /**
     *
     * @Route("/inscription", name="register")
     * @param EntityManagerInterface $em
     */

    public function __construct( EntityManagerInterface $em )
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(User::class);
    }

    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }



        return $this->render('user/register.html.twig',[
            'form' => $form->createView()
            ]);


    }

     /**
     *
     * @Route("/connexion", name="login")
     */
     public function login(): Response
     {
        return $this->render('user/login.html.twig',[
            'controller_name' => 'UserController',
        ]);
     }

}