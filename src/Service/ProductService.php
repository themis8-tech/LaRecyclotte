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
<<<<<<< HEAD
        return $this->repository->findTotalProducts();
    }
    
    public function buildResult($query, $sortDate, $sortCat, $sortState, $page, $limit)
    {
       
        return $this->repository->search($query, $sortDate, $sortCat, $sortState, $page, $limit);
=======
        
        return $this->repository->search($query, $sortDate, $sortCat, $sortState);
>>>>>>> master
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