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

                $this->addFlash('success', 'Vos modifications ont bien été enregistrées');
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

    /**
     * 
     * @Route("/supprimer_profil"), name="delete_profile")
     * @return Response
     */
    public function deleteUser(Request $request)
    {
        $active = 'delete';
        $user = $this->getUser();

        if($user == null)
        {
            return $this->redirect($this->generateUrl('profile'));
        }

        $form = $this->createFormBuilder()->getForm;

        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }
    }
}
