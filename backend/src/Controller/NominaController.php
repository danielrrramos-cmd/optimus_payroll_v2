<?php

namespace App\Controller;

use App\Entity\Nomina;
use App\Repository\EmpleadoRepository;
use App\Repository\NominaRepository;
use App\Service\NominaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/nominas')]
class NominaController extends AbstractController
{
    #[Route('', name: 'nominas_list', methods: ['GET'])]
    public function index(Request $request, NominaRepository $repo): JsonResponse
    {
        $empresaId = $this->getUser()->getEmpresa()->getId();
        $empleadoId = $request->query->get('empleado_id') ? (int)$request->query->get('empleado_id') : null;
        $nominas = $repo->findByEmpresa($empresaId, $empleadoId);

        return $this->json($nominas, 200, [], ['groups' => 'nomina:read']);
    }

    #[Route('/{id}', name: 'nominas_show', methods: ['GET'])]
    public function show(Nomina $nomina): JsonResponse
    {
        $this->denyUnlessGrantedEmpresa($nomina);

        return $this->json($nomina, 200, [], ['groups' => 'nomina:read']);
    }

    #[Route('/generar', name: 'nominas_generar', methods: ['POST'])]
    public function generar(
        Request $request,
        EmpleadoRepository $empleadoRepo,
        NominaService $nominaService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $empleadoId = $data['empleado_id'] ?? null;
        $mes = $data['mes'] ?? null;
        $anio = $data['anio'] ?? null;

        if (!$empleadoId || !$mes || !$anio) {
            return $this->json(['error' => 'Faltan campos: empleado_id, mes, anio'], 400);
        }

        $empleado = $empleadoRepo->find($empleadoId);
        if (!$empleado || $empleado->getEmpresa()->getId() !== $this->getUser()->getEmpresa()->getId()) {
            return $this->json(['error' => 'Empleado no encontrado'], 404);
        }

        $result = $nominaService->generar($empleado, str_pad($mes, 2, '0', STR_PAD_LEFT), $anio);

        if (is_string($result)) {
            return $this->json(['error' => $result], 409);
        }

        return $this->json($result, 201, [], ['groups' => 'nomina:read']);
    }

    #[Route('/{id}', name: 'nominas_delete', methods: ['DELETE'])]
    public function delete(Nomina $nomina, \Doctrine\ORM\EntityManagerInterface $em): JsonResponse
    {
        $this->denyUnlessGrantedEmpresa($nomina);

        $em->remove($nomina);
        $em->flush();

        return $this->json(null, 204);
    }

    private function denyUnlessGrantedEmpresa(Nomina $nomina): void
    {
        if ($nomina->getEmpresa()->getId() !== $this->getUser()->getEmpresa()->getId()) {
            throw $this->createAccessDeniedException();
        }
    }
}
