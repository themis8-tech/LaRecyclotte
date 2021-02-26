<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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

    /**
     * @Route("/contact", name="contact")
     */

    public function contact(Request $request, MailerInterface $mailer)
    {
        $user = new User();
        $contact = new Contact();
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('larecyclotte@gmail.com')
                ->subject('Mail recu')
                ->text('Sender : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');
            $mailer->send($message);

            //envoi du mail
            $mail = new Email();$mail->from('larecyclotte@gmail.com');
            $mail->to($user->getEmail());
            $mail->subject('Message de notification');




            //affichage de la vue dédié dans le corps du mail
            $view = $this->renderView('mail/notification-mail.html.twig', array(
                'user' => $user,
            ));
            $mail->html($view);

            $mailer->send($mail);



            $this->addFlash('success', 'Votre message est envoyé;nous vous repondons rapidement');

            return $this->redirectToRoute('contact');
        }



        return $this->render('single/contact.html.twig', [
            'our_form' => $form->createView()
        ]);
    }



















}