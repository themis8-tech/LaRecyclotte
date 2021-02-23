<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("", name="user_")
 */

class UserController extends AbstractController
{
    private $em;
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $this->em->getRepository(User::class);
    }
    /**
     *
     * @Route("/inscription", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', 'Félicitations ! Votre compte à bien été créé');
            return $this->redirectToRoute('main_home');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('main_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        if ($error) {
            $this->addFlash('danger', 'Email ou mot de passe incorrect');
        }

        return $this->render('user/login.html.twig', array(
            'lastEmail' => $authenticationUtils->getLastUsername(),
        ));
    }

    /**
     * @Route("/déconnexion", name="logout")
     */
    public function logout()
    {
    }

    /**
     * @Route("/reset/ask", name="reset_ask")
     */
    public function resetAsk(Request $request): Response
    {
        //recuperation du mail entré dasn le formulaire
        $email = $request->request->get('email');

        //retrouver le mail dasn la bdd
        $message = "";
        if (!empty($email)) {
            $user = $this->repository->findOneBy(array(
                'email' => $email
            ));

            //generation du token de reintialisation unique
            if (!empty($user)) {
                $token = bin2hex(random_bytes(24));
                $user->setToken($token);

                //validité du reset de 10 mn
                $now = new DateTime();
                $now->add(new DateInterval('PT600S'));
                $user->setTokenExpiredAt($now);

                //insertion du token dans la bdd sur l'user concerné
                $this->em->flush();

                //envoi du mail
                $mail = new Email();
                $mail->from('larecyclotte@gmail.com');
                $mail->to($user->getEmail());
                $mail->subject('Réinitialisation de mot de passe');

                //affichage de la vue dédié dans le corps du mail
                $view = $this->renderView('mail/reset-mail.html.twig', array(
                    'user' => $user,
                ));
                $mail->html($view);

                $mailer->send($mail);
            }

            $message = "Vous allez recevoir un lien de réinitialisation valable 2 heures";
        }
    }
    
    /**
     * @Route("/reset/confirm", name="reset_confirm")
     */
    public function resetConfirm(Request $request): Response
    {
        $token = $request->query->get('token');
        $user = $this->repository->findOneBy(array(
            'token' => $token,
        ));

        $now = new DateTime();
        if (empty($user) || $user->getTokenExpiredAt() < $now) {
            throw new NotFoundHttpException();
        }

        return new Response('Formulaire de changement de mot de passe');
    }
}
