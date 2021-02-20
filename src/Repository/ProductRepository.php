<?php

namespace App\Repository;


use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // Requete de recherche form general
    public function search ($query)
    { 
        $stmt = $this->createQueryBuilder('p');
        
        //si query est vide : affichage de tous les produits sinon apllication des filtres
        if(!empty($query)){
        
        $stmt->leftJoin('p.category', 'c');

        $stmt->where('p.name LIKE :query');
        $stmt->orwhere('c.name LIKE :query');
        $stmt->orwhere('p.city LIKE :query');

        $stmt->setParameter('query', '%' . $query . '%'); 
        }
    
        return $stmt->getQuery()->getResult();
    }

}
