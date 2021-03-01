<?php

namespace App\Controller;

use DateTime;
use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use App\Service\StateService;
use App\Entity\ContactDisplay;
use App\Service\ProductService;
use App\Form\ContactDisplayType;
use App\Service\CategoryService;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\StateRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
* @Route("/produit", name="product_")
*/
class ProductController extends AbstractController
{
    private $productService;
    private $categoryService;
    private $stateService;
    private $em;
    
    public function __construct(ProductService $productService, EntityManagerInterface $em,
     CategoryService $categoryService, StateService $stateService)

    {
         $this->productService = $productService;
         $this->categoryService = $categoryService;
         $this->stateService = $stateService;
         $this->em = $em;
    }

    /**
    * @Route("/liste", name="list")
    */
    public function list(Request $request, ProductRepository $repo,
     CategoryRepository $category, StateRepository $state ): Response
    {
        // Nombre d'éléments par page
        $limit = 12;
        $page= $request->query->get("page", 1);

        // Moteur de recherche interne
        $query = $request->query->get('q');
        // Tri select
        $sortDate   = $request->query->get('sortDate');
        $sortCat = $request->query->get('sortCat');
        $sortState = $request->query->get('sortState');

        $products = $this->productService->buildResult($query, $sortDate, $sortCat, $sortState, $page, $limit);
        $total = $this->productService->getTotalProducts(); 

        $category = $this->categoryService->getAll();
        $state = $this->stateService->getAll();
        
            return $this->render('product/list.html.twig', array(
            'products' => $products,
            'query'    => $query,
            'category' => $category,
            'state'    => $state,
            'limit'    => $limit,
            'page'     => $page,
            'total'    => $total
            ),
          
        );
    }

    /**
    * @Route("/{id}", name="display", requirements={"id"="\d+"})
    */
    public function display($id, Request $request, MailerInterface $mailer): Response
    {
        // Annonce de l'ID correspondant
        $product = $this->productService->getOne($id);

        if (empty($product) || ($product->getUser() != $this->getUser() && $product->getEnabled() == false)) {
            throw new NotFoundHttpException("L'annonce n'est plus active ou n'existe pas");
        }

        // Annonces postées par le donneur
        $productByUser = $this->productService->getBy('user', $product->getUser());

        // Formulaire de contact (utilisateur intéressé -> donneur)
        $contact = new ContactDisplay();
        $form = $this->createForm(ContactDisplayType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $email = new Email();
            $email->from("larecyclotte@gmail.com")
                ->to($product->getUser()->getEmail())
                ->replyTo($data->getEmail())
                ->subject('La Recyclotte - Une personne est intéressée par votre annonce : '.$product->getTitle());

            $viewEmail = $this->renderView('mail/product-contact.html.twig', array(
                'product' => $product,
                'data' => $data
            ));
    
            $email->html($viewEmail);
            $mailer->send($email);
            
            $notification = new Email();
            $notification->from("larecyclotte@gmail.com")
                ->to($data->getEmail())
                ->replyTo("larecyclotte@gmail.com")
                ->subject('La Recyclotte - Vous venez de contacter '.$product->getUser()->getUsername().' au sujet de son annonce : '.$product->getTitle());

            $viewNotification = $this->renderView('mail/product-notification.html.twig', array(
                'product' => $product,
                'data' => $data
            ));
    
            $notification->html($viewNotification);
            $mailer->send($notification);

            $this->addFlash('success', 'Votre email a bien été envoyé.');
            return $this->redirectToRoute('product_display', array(
                'id' => $product->getId()
            ));
        }
        
        return $this->render('product/display.html.twig', array(
            'product' => $product,
            'productByUser' => $productByUser,
            'form' => $form->createView()
        ));
    }

    /**
    * @IsGranted("ROLE_USER")
    * @Route("/donner", name="create")
    * 
    */
    public function create(Request $request, SluggerInterface $slugger,
     FileUploader $fileUploader, UserRepository $userRepo, MailerInterface $mailer ): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
     
        if($form->isSubmitted() && $form->isValid()  )
        {
            $picture = $form->get('picture')->getData();
            $product->setUser($this->getUser());
            if ($picture) {
                $pictureFileName = $fileUploader->upload($picture);
                $product->setPicture($pictureFileName);

                $this->em->persist($product);
                $this->em->flush();

                 //envoi du mail de confirmation d'enregistrement de l'objet
                 $mail = new Email();
                 $mail->from('larecyclotte@gmail.com');
                 $mail->to($product->getUser()->getEmail());
                 $mail->subject('Enregistrement de votre annonce');

                //affichage de la vue dédié dans le corps du mail
                $view = $this->renderView('mail/confirm-register-product.html.twig', array(
                   "product" => $product
                ));
                $mail->html($view);

                $mailer->send($mail);

                $this->addFlash(
                'success',
                "Félicitations ! Votre annonce est enregistrée
                , celle-ci sera publiée sous 24h. Merci d'avoir choisi La Recyclotte"          
            );
            }
            
            // return $this->redirectToroute('product_display', array(
            //     'id' => $product->getId()
            // ));
            
        }


        return $this->render('product/create.html.twig', array(
            'form' => $form ->createView(),
        ));
    }

    /**
    * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
    */
    public function delete($id, MailerInterface $mailer)
    {
        $product = $this->productService->getOne($id);
        //dd($product);
        $this->em->remove($product);
        $this->em->flush();

        // Send notification
        $notification = new Email();
        $notification->from("larecyclotte@gmail.com")
            ->to($product->getUser()->getEmail())
            ->replyTo("larecyclotte@gmail.com")
            ->subject('La Recyclotte - Notification de supression de votre annonce : '.$product->getTitle());

        $viewNotification = $this->renderView('mail/delete-product.html.twig', array(
            'product' => $product,
        ));

        $notification->html($viewNotification);
        $mailer->send($notification);

        // Add Modal Message
        $this->addFlash(
            'success',
            "Votre annonce a bien été supprimée."          
        );

        return $this->redirectToRoute('product_list', array(
            'product' => $product,
        ));
    }
}
