<?php

namespace App\Entity;

use App\Repository\EmpleadoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmpleadoRepository::class)]
#[ORM\Table(name: 'empleados')]
class Empleado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['empleado:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Empresa::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Empresa $empresa = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['empleado:read', 'empleado:write', 'nomina:read'])]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Groups(['empleado:read', 'empleado:write', 'nomina:read'])]
    private ?string $apellidos = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Groups(['empleado:read', 'empleado:write', 'nomina:read'])]
    private ?string $dni = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\Positive]
    #[Groups(['empleado:read', 'empleado:write'])]
    private ?string $salarioBase = null;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    #[Assert\PositiveOrZero]
    #[Groups(['empleado:read', 'empleado:write'])]
    private ?string $irpf = null;

    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    #[Assert\PositiveOrZero]
    #[Groups(['empleado:read', 'empleado:write'])]
    private ?string $seguridadSocial = null;

    public function getId(): ?int { return $this->id; }

    public function getEmpresa(): ?Empresa { return $this->empresa; }
    public function setEmpresa(?Empresa $empresa): static { $this->empresa = $empresa; return $this; }

    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }

    public function getApellidos(): ?string { return $this->apellidos; }
    public function setApellidos(string $apellidos): static { $this->apellidos = $apellidos; return $this; }

    public function getDni(): ?string { return $this->dni; }
    public function setDni(string $dni): static { $this->dni = $dni; return $this; }

    public function getSalarioBase(): ?string { return $this->salarioBase; }
    public function setSalarioBase(string $salarioBase): static { $this->salarioBase = $salarioBase; return $this; }

    public function getIrpf(): ?string { return $this->irpf; }
    public function setIrpf(string $irpf): static { $this->irpf = $irpf; return $this; }

    public function getSeguridadSocial(): ?string { return $this->seguridadSocial; }
    public function setSeguridadSocial(string $seguridadSocial): static { $this->seguridadSocial = $seguridadSocial; return $this; }
}
