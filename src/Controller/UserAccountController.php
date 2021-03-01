<?php

namespace App\Controller;


use App\Form\EditProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\User;
use App\Entity\Product;

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
     * @Route("/suppression_compte", name="deleteuserPage")
     * @return Response
     */
    public function deleteuserPage()
    {
        return $this->render('user_account/deleteuser.html.twig');

    }

    /**
     * @Route("/suppression_annonce/{id}", name="deleteproduct")
     * @method({"DELETE"})
     */
    public function deleteProduct($id)
    {

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
                
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('success', 'Votre annonce a bien été supprimé !');

        return $this->redirectToRoute('user_account_myproducts');
    }

    /**
     * @Route("/suppression_compte/{id}", name="deleteuser")
     * @method({"DELETE"})
     */
    public function deleteUser($id)
    {

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
                
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte a bien été supprimé !');

        return $this->redirectToRoute('main_home');
    }

}
