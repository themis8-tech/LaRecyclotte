<?php

namespace App\Controller;

use App\entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;



class SingleController extends AbstractController
{
    /**
     * @Route("/concept", name="concept")
     */
    public function index(): Response
    {
        return $this->render('single/concept.html.twig', [
            'controller_name' => 'ConceptController',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contact(Request $request, MailerInterface $mailer)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('@gmail.com')
                ->subject('Mail recu')
                ->text('Sender : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['Message'],
                    'text/plain');
            $mailer->send($message);




            $this->addFlash('success', 'Votre message est envoyé');

            return $this->redirectToRoute('contact');
        }



        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView()
        ]);
    }



















}
