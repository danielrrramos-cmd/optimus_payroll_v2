<?php

namespace App\Entity;

use App\Repository\EmpresaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
#[ORM\Table(name: 'empresas')]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['empresa:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['empresa:read'])]
    private ?string $nombre = null;

    #[ORM\Column(length: 20)]
    #[Groups(['empresa:read'])]
    private ?string $cif = null;

    #[ORM\Column(length: 255)]
    #[Groups(['empresa:read'])]
    private ?string $direccion = null;

    #[ORM\Column(length: 20)]
    #[Groups(['empresa:read'])]
    private ?string $telefono = null;

    public function getId(): ?int { return $this->id; }
    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }
    public function getCif(): ?string { return $this->cif; }
    public function setCif(string $cif): static { $this->cif = $cif; return $this; }
    public function getDireccion(): ?string { return $this->direccion; }
    public function setDireccion(string $direccion): static { $this->direccion = $direccion; return $this; }
    public function getTelefono(): ?string { return $this->telefono; }
    public function setTelefono(string $telefono): static { $this->telefono = $telefono; return $this; }
}
