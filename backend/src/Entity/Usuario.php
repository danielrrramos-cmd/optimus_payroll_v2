<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\Table(name: 'usuarios')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    private ?string $usuario = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(targetEntity: Empresa::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Empresa $empresa = null;

    public function getId(): ?int { return $this->id; }

    public function getUsuario(): ?string { return $this->usuario; }
    public function setUsuario(string $usuario): static { $this->usuario = $usuario; return $this; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }

    public function getEmpresa(): ?Empresa { return $this->empresa; }
    public function setEmpresa(?Empresa $empresa): static { $this->empresa = $empresa; return $this; }

    // UserInterface methods
    public function getRoles(): array { return ['ROLE_USER']; }
    public function eraseCredentials(): void {}
    public function getUserIdentifier(): string { return $this->usuario; }
}
