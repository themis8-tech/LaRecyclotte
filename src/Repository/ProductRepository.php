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
    public function search($query, $sortDate, $sortCat, $sortState, $page, $limit)
    { 
        $stmt = $this->createQueryBuilder('p');
        
        //si query est vide : affichage de tous les produits sinon apllication des filtres
        if(!empty($query)){
            
            $stmt->leftJoin('p.category', 'c');

            $stmt->where('p.title LIKE :query');
            $stmt->orwhere('c.name LIKE :query');
            $stmt->orwhere('p.city LIKE :query');

            $stmt->setParameter('query', '%' . $query . '%'); 
        }
        if(!empty($sortCat))
        {
            $stmt->leftJoin('p.category', 'c');
            $stmt->andWhere('c.name LIKE :sort1');
           $stmt->setParameter('sort1', '%' . $sortCat . '%');
        }
         if(!empty($sortState))
        {
            $stmt->leftJoin('p.state', 's');
            $stmt->andWhere('s.name LIKE :sort');
            $stmt->setParameter('sort', '%' . $sortState . '%');
        }
        
        $stmt->orderby('p.createdAt', $sortDate);
        $stmt->setFirstResult(($page * $limit) - $limit);
        $stmt->setMaxResults($limit);
        //dd($stmt->getQuery());
        
        
        return $stmt->getQuery()->getResult();
    }

    public function findTotalProducts()
    {
        $stmt = $this->createQueryBuilder('p');
        $stmt->select('COUNT(p)');
    
         return $stmt->getQuery()->getSingleScalarResult();   
    }

    //Caroussel homepage
    public function findLast()
    {
        $stmt = $this->createQueryBuilder('p');
        
        $stmt->where('p.endAt > CURRENT_TIMESTAMP()');
        $stmt->setMaxResults(10);
        $stmt->orderBy('p.createdAt', 'DESC');

        return $stmt->getQuery()->getResult();
    }

}
