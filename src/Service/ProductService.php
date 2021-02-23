<?php
namespace App\Service;

use App\Repository\ProductRepository;

class ProductService{
    private $repository;

    public function __construct( ProductRepository $repository)
    {
        $this->repository = $repository;
        
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

    public function buildResult($query, $sortDate, $sortCat, $sortState)
    {
        //dd($sortState, $sortDate, $sortCat);
        return $this->repository->search($query, $sortDate, $sortCat, $sortState);
    }

    public function getLast()
    {
        return $this->repository->findLast();
    }
    
   }