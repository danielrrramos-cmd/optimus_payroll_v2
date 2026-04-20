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

        return $this->json([
            'usuario' => $user->getUserIdentifier(),
            'empresa_id' => $user->getEmpresa()->getId(),
            'empresa_nombre' => $user->getEmpresa()->getNombre(),
        ]);
    }
}
