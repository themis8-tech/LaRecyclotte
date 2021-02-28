<?php
namespace App\Service;

use App\Entity\ContactDisplay;
use App\Repository\ProductRepository;
use Symfony\Component\Mailer\MailerInterface;

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

    public function getTotalProducts()
    {
        return $this->repository->findTotalProducts();
    }
    
    public function buildResult($query, $order, $category, $state, $page, $limit)
    {
       
        return $this->repository->search($query, $order, $category, $state, $page, $limit);
    }

    public function getLast()
    {
        return $this->repository->findLast();
    }

    public function getOne($id)
    {
        return $this->repository->find($id);
    }

    public function getBy($column, $data)
    {
        return $this->repository->findBy(
            array($column => $data)
        );
    }
}

