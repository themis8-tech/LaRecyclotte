<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use App\Service\StateService;
use App\Service\ProductService;
use App\Service\CategoryService;
use App\Repository\UserRepository;
use App\Repository\StateRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
    public function display($id): Response
    {
        $product = $this->productService->getOne($id);

        if (empty($product)) {
            throw new NotFoundHttpException("L'annonce n'est plus active ou n'existe pas");
        }
        
        return $this->render('product/display.html.twig', array(
            'product' => $product,
        ));
    }

    /**
    * @IsGranted("ROLE_USER")
    * @Route("/create", name="create")
    * 
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
