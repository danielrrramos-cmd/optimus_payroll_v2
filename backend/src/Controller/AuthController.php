<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        // This is handled by the security firewall (json_login + JWT)
        // If we reach here, authentication failed
        return $this->json(['error' => 'Credenciales inválidas'], 401);
    }

    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        $empresa = $user->getEmpresa();

        return $this->json([
            'usuario'           => $user->getUserIdentifier(),
            'empresa_id'        => $empresa->getId(),
            'empresa_nombre'    => $empresa->getNombre(),
            'empresa_cif'       => $empresa->getCif(),
            'empresa_direccion' => $empresa->getDireccion(),
            'empresa_telefono'  => $empresa->getTelefono(),
        ]);
    }
}
