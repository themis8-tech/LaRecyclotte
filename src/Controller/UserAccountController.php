<?php

namespace App\Controller;


use App\Form\EditProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("", name="user_account_")
 */
class UserAccountController extends AbstractController
{

    /**
     *
     * @Route("/profil", name="profile")
     * @return Response
     */
    public function profile()
    {

        return $this->render('user_account/profile.html.twig');

    }

    /**
     *
     * @Route("/modifier", name="editprofile")
     * @return Response
     */
    public function editProfile(Request $request)
    {
            $user = $this->getUser();
            $form = $this->createForm(EditProfileType::class, $user);  
            
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->flush();

                $this->addFlash('message', 'Profil mis à jour');
                return $this->redirectToRoute('user_account_profile');
            }

            return $this->render('user_account/editprofile.html.twig', [
                'form' => $form->createView(),
            ]);

    }

    /**
     *
     * @Route("/mes_annonces", name="myproducts")
     * @return Response
     */
    public function productShow()
    {

        return $this->render('user_account/myproducts.html.twig');

    }
}
