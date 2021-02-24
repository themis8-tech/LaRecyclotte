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

    public function sendEmail(ContactDisplay $contact, MailerInterface $mailer)
    {

    }
    
   }