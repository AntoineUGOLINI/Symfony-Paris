<?php

namespace App\Repository;

use App\Entity\Fiche;
use App\Entity\Organisme;
use App\Entity\Rubrique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fiche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiche[]    findAll()
 * @method Fiche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiche::class);
    }

    // /**
    //  * @return Fiche[] Returns an array of Fiche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fiche
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function myFindOne($id)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.id = :id')
            ->setParameter('id', $id)
        ;

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
    public function getOrgByRub(Organisme $organisme)
    {
        $qb = $this->createQueryBuilder("o")
            ->where(':organisme MEMBER OF o.rubriques')
            ->setParameters(array('organisme' => $organisme))
        ;
        return $qb->getQuery()->getResult();
    }
    public function findByOrgRub(){
        $query = $this->createQueryBuilder('o')
            ->select('o')
            ->leftJoin('o.rubriques', 'r')
            ->where('o==r')
            ->orderBy('r', 'DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }

}
