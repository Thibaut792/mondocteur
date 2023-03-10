<?php

namespace App\Repository;

use App\Entity\RDV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RDV>
 *
 * @method RDV|null find($id, $lockMode = null, $lockVersion = null)
 * @method RDV|null findOneBy(array $criteria, array $orderBy = null)
 * @method RDV[]    findAll()
 * @method RDV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RDVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RDV::class);
    }

    public function add(RDV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RDV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findNbRdvInCurrentMonth()
    {
        return $this->createQueryBuilder('r')
            ->select('r, COUNT(r.id) as nbrdv')
            ->Where('MONTH(r.creneau) = MONTH(NOW())')
            ->andWhere('YEAR(r.creneau) = YEAR(NOW())')
            ->groupBy('r.medecin')
            ->orderBy("nbrdv", 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findNbRdvInCurrentMonth2()
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT r ,  COUNT(r.id) as nbrdv
            FROM App\Entity\Rdv r
            WHERE MONTH(r.creneau) = MONTH(NOW()) and YEAR(r.creneau) = YEAR(NOW())
            group by r.medecin
            ORDER BY nbrdv DESC'
        );
        // returns an array of Product objects
        return $query->getResult();
    }
    public function findRdvForOneDocteur($docteur)
    {
        return $this->createQueryBuilder('r')
            ->select('r, t, u')
            ->join('r.typeconsultation', 't')
            ->join('r.user', 'u')
            ->Where('MONTH(r.creneau) = MONTH(NOW())')
            ->andWhere('YEAR(r.creneau) = YEAR(NOW())')
            ->andWhere('DAY(r.creneau) = DAY(NOW())')
            ->andWhere('r.medecin = :medecin')
            ->setParameter(':medecin', $docteur)
            ->orderBy("r.creneau", 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return RDV[] Returns an array of RDV objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RDV
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
