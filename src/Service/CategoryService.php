<?php
namespace App\Service;

use App\Repository\CategoryRepository;

class CategoryService{
    private $repository;

    public function __construct( CategoryRepository $repository)
    {
        $this->repository = $repository;
        
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

}