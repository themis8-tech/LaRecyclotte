<?php

namespace App\Controller;

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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
* @Route("/product", name="product_")
*/
class ProductController extends AbstractController
{
    private $productService;
    private $categoryService;
    private $stateService;
    
    public function __construct(ProductService $productService, EntityManagerInterface $em,
     CategoryService $categoryService, StateService $stateService)

    {
         $this->productService = $productService;
         $this->categoryService = $categoryService;
         $this->stateService = $stateService;
         $this->em = $em;
    }

    /**
    * @Route("/list", name="list")
    */
    public function list(Request $request, ProductRepository $repo,
     CategoryRepository $category, StateRepository $state ): Response
    {
        // Moteur de recherche interne
        $query = $request->query->get('q');
        // Tri select
        $sortDate   = $request->query->get('sortDate');
        $sortCat = $request->query->get('sortCat');
        $sortState = $request->query->get('sortState');
        $products = $this->productService->buildResult($query, $sortDate, $sortCat, $sortState);
       
        $category = $this->categoryService->getAll();
        $state = $this->stateService->getAll();
            return $this->render('product/list.html.twig', array(
            'products'=> $products,
            'query'=> $query,
            'category' => $category,
            'state' => $state,
            ),
          
        );
    }

    /**
    * @Route("/{id}", name="display", requirements={"id"="\d+"})
    */
    public function display($id, Request $request, MailerInterface $mailer): Response
    {
        $product = $this->productService->getOne($id);
        $productByUser = $this->productService->getBy('user', $product->getUser());

        if (empty($product)) {
            throw new NotFoundHttpException("L'annonce n'est plus active ou n'existe pas");
        }

        $contact = new ContactDisplay();
        $form = $this->createForm(ContactDisplayType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $email = new Email();
            $email->from($data->getEmail())
                ->to($product->getUser()->getEmail())
                ->cc($data->getEmail())
                ->replyTo($data->getEmail())
                ->subject('La Recyclotte - Réponse à votre annonce : '.$product->getTitle().' (annonce #'.$product->getId().')')
                ->html('<p>Bonjour, vous recevez ce mail car une personne à répondu à votre annonce passée sur le site de la Recyclotte.</p><h3>Votre annonce</h3><ul><li>Titre : <b>'.$product->getTitle().' ('.$product->getState()->getName().')</b></li><li>Lieu de retrait : <b>'.$product->getCity().' ('.$product->getZipcode()->getCode().')</b></li><li>Posté le : <b>'.$product->getCreatedAt()->format('j M Y \à G:i').'</b></li></ul><h3>Informations de la personne intéressée</h3><ul><li>Nom d\'utilisateur : <b>'.$data->getUsername().'</b></li><li>Email : <b>'.$data->getEmail().'</b></li><li>Téléphone : <b>'.$data->getPhone().'</b></li><li>Message : <b>'.$data->getMessage().'</b></li></ul><p>Nous vous invitons à répondre directement à ce mail pour entrer en contact avec la personne intéressée.</p><p>Cordialement,<br>L\'équipe de La Recyclotte.</p>');
            
            $mailer->send($email);

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
    * @Route("/create", name="create")
    */
    public function create(Request $request, SluggerInterface $slugger,
     FileUploader $fileUploader, UserRepository $userRepo): Response
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
                $this->addFlash('success',
                                "Félicitation ! Votre annonce est enregistrée
                                , celle-ci sera publiée sous 24h.
                                Merci d'avoir choisi La Recyclotte"
            );
            }
            return $this->redirectToroute('product_display', array(
                'id' =>$product->getId(),
            ));
            
        }


        return $this->render('product/create.html.twig', array(
            'form' => $form ->createView(),
        ));
    }
}
