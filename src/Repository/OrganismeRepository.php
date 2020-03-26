<?php

namespace App\Repository;

use App\Entity\Organisme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method Organisme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organisme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organisme[]    findAll()
 * @method Organisme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganismeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organisme::class);
    }

    // /**
    //  * @return Organisme[] Returns an array of Organisme objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Organisme
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findIdOrg($organisme){
        return $this->createQueryBuilder('o')
            ->select('o.id')
            ->where('u.username = :username')
            ->setParameter('organisme_id',$organisme)
            ->getQuery()->getResult();
    }
    public function getOrgByRub(Organisme $organisme)
    {
        $qb = $this->createQueryBuilder("o")
            ->where(':organisme MEMBER OF o.rubriques')
            ->setParameters(array('organisme' => $organisme))
        ;
        return $qb->getQuery()->getResult();
    }
    public function findByRub($rubrique_id){
       /* $sql='Select nom_off
        from organisme
        inner join organisme on rubrique.organisme=organisme.rubrique
        where rubrique.organisme==organisme.rubrique'*/

        //$query = $this->createQueryBuilder('o')
            //->select('o')
            //->setParameter($rubriques,'rubrique.organisme')
            //->leftJoin('rubrique.organisme', 'r')
            //->where('o==r', 'v')
            //->orderBy('r', 'DESC')
            //->setParameter('v',$organismes)
            //->getQuery()
            //->getResult();

        //$em = $this->getContainer()->get('doctrine')->getManager();
        //$repository = $em->getRepository('App/Entity/Organisme');
        $qb = $this->getEntityManager()->createQueryBuilder();
        //$query = $em->getRepository('App/Entity/Organisme')->createQueryBuilder('o')
        $request=$qb->select('o')
            ->from('App\Entity\Organisme','o')
            ->innerJoin('o.rubrique', 'r')
            ->where('o.id = :r')
            ->setParameter('r', $rubrique_id)
            ->getQuery()->getResult();
        /*$query = $entityManager->createQuery(
            'SELECT o, o.nom_off
            FROM App\Entity\Organisme o'
        );*/
        return $request;
        //return $query;
    }
    public function findidRub(){
        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = 'SELECT rubrique_organisme.organisme_id
                          FROM rubrique
                          INNER join rubrique_organisme on rubrique.id=rubrique_organisme.rubrique_id
                          Where rubrique.id=1';
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        //$statement->bindValue('$rubrique_id', $rubrique_id);
        $statement->execute();

        $result = $statement->fetchAll();
        return $result;
    }
}
