<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



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
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            //envoi du mail
            $mail = new Email();
            $mail->from('larecyclotte@gmail.com');
            $mail->to($contact->getEmail());
            $mail->subject('Réception de votre message');

            //affichage de la vue dédié dans le corps du mail
            $view = $this->renderView('mail/contact-confirm.html.twig', array(
                'contact' => $contact,
            ));
            $mail->html($view);
            $mailer->send($mail);

            
            //envoi de la notification
            $notification = new Email();
            $notification->from($contact->getEmail());
            $notification->to('larecyclotte@gmail.com');
            $notification->subject("Réception d'un nouveau message");

            $viewNotification = $this->renderView('mail/contact-notification.html.twig', array(
            'contact' => $contact,
                ));

            $notification->html($viewNotification);
            $mailer->send($notification);
            
            $this->addFlash('success', 'Félicitations ! Votre message a bien été envoyé. Vous allez recevoir un mail de confirmation.');
            return $this->redirectToRoute('main_home');

        }

        return $this->render('single/contact.html.twig', [
            'our_form' => $form->createView()
        ]);
    }



}