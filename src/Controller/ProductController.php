<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/product", name="product_")
*/
class ProductController extends AbstractController
{
    private $productService;
    
    public function __construct(ProductService $productService)
    
    {
         $this->productService = $productService;

    }


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
    public function display(): Response
    {
        return $this->render('product/display.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
