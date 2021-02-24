<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use App\Service\ProductService;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    
    public function __construct(ProductService $productService, EntityManagerInterface $em)

    {
         $this->productService = $productService;
         $this->em = $em;
    }

    /**
    * @Route("/list", name="list")
    */
    public function list(Request $request): Response
    {
        //$query = $request->query->get('q');

       // $products = $this->productService->buildResult($query);
        
        return $this->render('product/list.html.twig', array(
            //'products'=> $products,
            //'query'=> $query,
        ));
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
    * @Route("/create", name="create")
    */
    public function create(Request $request, SluggerInterface $slugger, FileUploader $fileUploader): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()  )
        {
            $picture = $form->get('picture')->getData();
            if ($picture) {
                $pictureFileName = $fileUploader->upload($picture);
                $product->setPicture($pictureFileName);

                $this->em->persist($product);
                $this->em->flush();
                $this->addFlash('success',
                                    "Votre objet est enregister celui-ci sera
                                    publié dans les 24h"
            );
            }
            return $this->redirectToroute('product_list');
            
        }


        return $this->render('product/create.html.twig', array(
            'form' => $form ->createView(),
        ));
    }
}
