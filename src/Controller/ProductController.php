<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/product", name="product_")
*/
class ProductController extends AbstractController
{
    private $productService;
    


    /**
    * @Route("/list", name="list")
    */
    public function list(): Response
    {

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
