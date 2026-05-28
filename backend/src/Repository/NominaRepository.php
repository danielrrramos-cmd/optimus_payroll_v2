<?php

namespace App\Repository;

use App\Entity\Nomina;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NominaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nomina::class);
    }

    public function findByEmpresa(int $empresaId, ?int $empleadoId = null): array
    {
        $qb = $this->createQueryBuilder('n')
            ->join('n.empleado', 'e')
            ->where('n.empresa = :empresaId')
            ->setParameter('empresaId', $empresaId)
            ->orderBy('n.fecha', 'DESC');

        if ($empleadoId !== null) {
            $qb->andWhere('n.empleado = :empleadoId')
               ->setParameter('empleadoId', $empleadoId);
        }

        return $qb->getQuery()->getResult();
    }

    public function findExisting(int $empleadoId, string $fecha): ?Nomina
    {
        return $this->createQueryBuilder('n')
            ->where('n.empleado = :empleadoId')
            ->andWhere('n.fecha = :fecha')
            ->setParameter('empleadoId', $empleadoId)
            ->setParameter('fecha', $fecha)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
