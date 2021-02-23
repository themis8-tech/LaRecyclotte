<?php
namespace App\Service;

use App\Repository\StateRepository;

class StateService{
    private $repository;

    public function __construct( StateRepository $repository)
    {
        $this->repository = $repository;
        
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

}