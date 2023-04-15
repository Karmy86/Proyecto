<?php

namespace App\Repository;

use App\Entity\Pacientes;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pacientes>
 *
 * @method Pacientes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pacientes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pacientes[]    findAll()
 * @method Pacientes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PacientesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pacientes::class);
    }

    public function new(string $nombre, string $apellidos, DateTime $fecha_nacimiento, int $telefono, string $email, string $observaciones){
        $paciente = new Pacientes();
        $paciente->setNombre($nombre)
            ->setApellidos($apellidos)
            ->setFechaNacimiento($fecha_nacimiento)
            ->setTelefono($telefono)
            ->setEmail($email)
            ->setObservaciones($observaciones);
        $this->getEntityManager()->persist($paciente);
        $this->getEntityManager()->flush();
    }

    public function save(Pacientes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Pacientes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Pacientes[] Returns an array of Pacientes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Pacientes
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
