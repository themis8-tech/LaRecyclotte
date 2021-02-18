<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/product", name="product_")
*/
class ProductController extends AbstractController
{

    /**
    * @Route("/list", name="list")
    */
    public function list(): Response
    {
        return $this->render('product/list.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
    * @Route("/display", name="display")
    */
    public function display(Request $request, ProductRepository $productRepository): Response
    {

        return $this->render('product/display.html.twig');
    }

    /**
    * @Route("/create", name="create")
    */
    public function create(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        //$form->handleRequest($request);

        return $this->render('product/create.html.twig', array(
            'form' => $form ->createView(),
        ));
    }
}
