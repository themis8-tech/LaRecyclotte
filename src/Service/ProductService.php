<?php
namespace App\Service;

use App\Repository\ProductRepository;

class ProductService{
    private $repository;

    public function __construct( ProductRepository $repository)
    {
        $this->repository = $repository;
        
    }

    public function buildResult($query)
    {
        return $this->repository->search( $query);
    }

    public function getLast()
    {
        return $this->repository->findLast();
    }

    public function getOne($id)
    {
        return $this->repository->find($id);
    }
    
   }