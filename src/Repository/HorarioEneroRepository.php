<?php

namespace App\Repository;

use App\Entity\HorarioEnero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HorarioEnero>
 *
 * @method HorarioEnero|null find($id, $lockMode = null, $lockVersion = null)
 * @method HorarioEnero|null findOneBy(array $criteria, array $orderBy = null)
 * @method HorarioEnero[]    findAll()
 * @method HorarioEnero[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HorarioEneroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HorarioEnero::class);
    }

    public function save(HorarioEnero $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HorarioEnero $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HorarioEnero[] Returns an array of HorarioEnero objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HorarioEnero
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
