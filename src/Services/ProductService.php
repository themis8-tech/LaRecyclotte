<?php
namespace App\Service;

use App\Repository\ProductRepository;

class ProductService{

   private $repository;

   public function __construct (ProductRepository $repositrory)
   {
      $this->repository = $repository;
   }

   public function buildResult($query, $sort)
    {
        return $this->repository->search( $query);
    }

}