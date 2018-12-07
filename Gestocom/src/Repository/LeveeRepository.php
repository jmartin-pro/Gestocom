<?php

namespace App\Repository;

use App\Entity\Levee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Levee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Levee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Levee[]    findAll()
 * @method Levee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LeveeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Levee::class);
    }
    
    public function findMoisEnCours() {
		return $this->createQueryBuilder('levee')
			->andWhere('levee.dateLevee BETWEEN :start AND :end')
			->orderBy('levee.dateLevee', 'DESC')
			->setParameter('start', new \Datetime(date('Y-m-').'1'))
			->setParameter('end',   new \Datetime(date('Y-m-t')))
			->getQuery()
			->getResult()
		;

	}

    // /**
    //  * @return Levee[] Returns an array of Levee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Levee
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
