<?php

namespace App\Repository;

use App\Entity\Pacientes;
use App\Entity\Reservas;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeImmutable;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @extends ServiceEntityRepository<Reservas>
 *
 * @method Reservas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservas[]    findAll()
 * @method Reservas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservas::class);
    }

    public function new(DateTimeImmutable $dia_hora, Pacientes $id_paciente){
        $reserva = new Reservas();
        $reserva->setDiaHora($dia_hora)
            ->setIdPaciente($id_paciente);
        $this->getEntityManager()->persist($reserva);
        $this->getEntityManager()->flush();
    }

    public function save(Reservas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Reservas[]
     */
    public function findAllByWeek(DateTimeImmutable $from, DateTimeImmutable $to): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.dia_hora >= :from')
            ->andWhere('r.dia_hora <= :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult();
    }

    public function findAllByWeekAndPatient(DateTimeImmutable $from, DateTimeImmutable $to, int $patientId): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.dia_hora >= :from')
            ->andWhere('r.dia_hora <= :to')
            ->andWhere('r.id_paciente = :patientId')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
            ->setParameter('patientId', $patientId)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Reservas[] Returns an array of Reservas objects
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

//    public function findOneBySomeField($value): ?Reservas
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
