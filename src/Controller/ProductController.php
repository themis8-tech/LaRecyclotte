<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        //$form->handleRequest($request);

        return $this->render('product/display.html.twig', array(
            'form' => $form -> createView(),
        ));
    }
}
