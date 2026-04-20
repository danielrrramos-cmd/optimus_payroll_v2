<?php

namespace App\Repository;

use App\Entity\Empleado;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmpleadoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empleado::class);
    }

    public function findByEmpresa(int $empresaId): array
    {
        return $this->findBy(['empresa' => $empresaId]);
    }
}
