<?php

namespace App\Controller;

use App\Service\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $productService;
    
    public function __construct(ProductService $productService)

    {
         $this->productService = $productService;
    }

    /**
     * @Route("/", name="main_home")
     */
    public function home(): Response
    {
        $products = $this->productService->getLast();
        
        return $this->render('main/home.html.twig', array(
            'products'=> $products,
        ));
    }
}
