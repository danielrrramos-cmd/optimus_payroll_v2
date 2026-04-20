<?php

namespace App\Service;

use App\Entity\Empleado;
use App\Entity\Nomina;
use App\Repository\NominaRepository;
use Doctrine\ORM\EntityManagerInterface;

class NominaService
{
    public function __construct(
        private EntityManagerInterface $em,
        private NominaRepository $nominaRepository
    ) {}

    public function generar(Empleado $empleado, string $mes, string $anio): Nomina|string
    {
        $fecha = "$anio-$mes-01";

        $existente = $this->nominaRepository->findExisting($empleado->getId(), $fecha);
        if ($existente) {
            return 'Ya existe una nómina para este empleado en ese periodo.';
        }

        $bruto = (float) $empleado->getSalarioBase();
        $irpfCantidad = round($bruto * ((float) $empleado->getIrpf() / 100), 2);
        $ssCantidad = round($bruto * ((float) $empleado->getSeguridadSocial() / 100), 2);
        $neto = round($bruto - $irpfCantidad - $ssCantidad, 2);

        $nomina = new Nomina();
        $nomina->setEmpresa($empleado->getEmpresa());
        $nomina->setEmpleado($empleado);
        $nomina->setFecha(new \DateTime($fecha));
        $nomina->setBruto(number_format($bruto, 2, '.', ''));
        $nomina->setIrpfCantidad(number_format($irpfCantidad, 2, '.', ''));
        $nomina->setSsCantidad(number_format($ssCantidad, 2, '.', ''));
        $nomina->setNeto(number_format($neto, 2, '.', ''));

        $this->em->persist($nomina);
        $this->em->flush();

        return $nomina;
    }
}
