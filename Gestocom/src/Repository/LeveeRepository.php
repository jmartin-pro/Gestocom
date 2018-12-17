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
    
    public function findMois($month, $year) {
		return $this->createQueryBuilder('levee')
			->andWhere('levee.dateLevee BETWEEN :start AND :end')
			->orderBy('levee.dateLevee', 'DESC')
			->setParameter('start', new \Datetime(date($year.'-'.$month.'-1 00:00:00')))
			->setParameter('end',   new \Datetime(date($year.'-'.$month.'-t 23:59:59')))
			->getQuery()
			->getResult()
		;
	}
	
	public function findAnneeEnCours() {
		$previousYear = date('Y') - 1;
		$previousMounth = date('m') - 1;
	
		$tmpLevees = $this->createQueryBuilder('levee')
			->select('levee, MONTH(levee.dateLevee) AS month')
			->Where('levee.dateLevee BETWEEN :start AND :end')
			->orderBy('levee.dateLevee', 'ASC')
			->groupBy('month')
			->setParameter('start', new \Datetime(date($previousYear.'-m-1 00:00:00')))
			->setParameter('end',   new \Datetime(date('Y-'.$previousMounth.'-t 23:59:59')))
			->getQuery()
			->getResult()
		;
		
		$levees = array();
		foreach($tmpLevees as $levee) {
			array_push($levees, $levee[0]);
		}
		
		return $levees;
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
