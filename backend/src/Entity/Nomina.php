<?php

namespace App\Entity;

use App\Repository\NominaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NominaRepository::class)]
#[ORM\Table(name: 'nominas')]
class Nomina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['nomina:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Empresa::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Empresa $empresa = null;

    #[ORM\ManyToOne(targetEntity: Empleado::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['nomina:read'])]
    private ?Empleado $empleado = null;

    #[ORM\Column(type: 'date')]
    #[Groups(['nomina:read'])]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['nomina:read'])]
    private ?string $bruto = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['nomina:read'])]
    private ?string $irpfCantidad = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['nomina:read'])]
    private ?string $ssCantidad = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['nomina:read'])]
    private ?string $neto = null;

    public function getId(): ?int { return $this->id; }

    public function getEmpresa(): ?Empresa { return $this->empresa; }
    public function setEmpresa(?Empresa $empresa): static { $this->empresa = $empresa; return $this; }

    public function getEmpleado(): ?Empleado { return $this->empleado; }
    public function setEmpleado(?Empleado $empleado): static { $this->empleado = $empleado; return $this; }

    public function getFecha(): ?\DateTimeInterface { return $this->fecha; }
    public function setFecha(\DateTimeInterface $fecha): static { $this->fecha = $fecha; return $this; }

    public function getBruto(): ?string { return $this->bruto; }
    public function setBruto(string $bruto): static { $this->bruto = $bruto; return $this; }

    public function getIrpfCantidad(): ?string { return $this->irpfCantidad; }
    public function setIrpfCantidad(string $irpfCantidad): static { $this->irpfCantidad = $irpfCantidad; return $this; }

    public function getSsCantidad(): ?string { return $this->ssCantidad; }
    public function setSsCantidad(string $ssCantidad): static { $this->ssCantidad = $ssCantidad; return $this; }

    public function getNeto(): ?string { return $this->neto; }
    public function setNeto(string $neto): static { $this->neto = $neto; return $this; }
}
