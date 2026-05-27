<?php

namespace App\Controller;

use App\Entity\Empleado;
use App\Repository\EmpleadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/empleados')]
class EmpleadoController extends AbstractController
{
    #[Route('', name: 'empleados_list', methods: ['GET'])]
    public function index(EmpleadoRepository $repo): JsonResponse
    {
        $empresaId = $this->getUser()->getEmpresa()->getId();
        $empleados = $repo->findByEmpresa($empresaId);

        return $this->json($empleados, 200, [], ['groups' => 'empleado:read']);
    }

    #[Route('/{id}', name: 'empleados_show', methods: ['GET'])]
    public function show(Empleado $empleado): JsonResponse
    {
        $this->denyUnlessGrantedEmpresa($empleado);

        return $this->json($empleado, 200, [], ['groups' => 'empleado:read']);
    }

    #[Route('', name: 'empleados_create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $empresa = $this->getUser()->getEmpresa();

        $empleado = new Empleado();
        $empleado->setEmpresa($empresa);
        $empleado->setNombre(trim($data['nombre'] ?? ''));
        $empleado->setApellidos(trim($data['apellidos'] ?? ''));
        $empleado->setDni(strtoupper(trim($data['dni'] ?? '')));
        $empleado->setSalarioBase((string)($data['salarioBase'] ?? '0'));
        $empleado->setIrpf((string)($data['irpf'] ?? '0'));
        $empleado->setSeguridadSocial((string)($data['seguridadSocial'] ?? '0'));

        $errors = $validator->validate($empleado);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }
            return $this->json(['errors' => implode(' ', $messages)], 400);
        }

        $em->persist($empleado);
        $em->flush();

        return $this->json($empleado, 201, [], ['groups' => 'empleado:read']);
    }

    #[Route('/{id}', name: 'empleados_update', methods: ['PUT'])]
    public function update(
        Empleado $empleado,
        Request $request,
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        $this->denyUnlessGrantedEmpresa($empleado);

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) $empleado->setNombre(trim($data['nombre']));
        if (isset($data['apellidos'])) $empleado->setApellidos(trim($data['apellidos']));
        if (isset($data['dni'])) $empleado->setDni(strtoupper(trim($data['dni'])));
        if (isset($data['salarioBase'])) $empleado->setSalarioBase((string)$data['salarioBase']);
        if (isset($data['irpf'])) $empleado->setIrpf((string)$data['irpf']);
        if (isset($data['seguridadSocial'])) $empleado->setSeguridadSocial((string)$data['seguridadSocial']);

        $errors = $validator->validate($empleado);
        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[] = $error->getMessage();
            }
            return $this->json(['errors' => implode(' ', $messages)], 400);
        }

        $em->flush();

        return $this->json($empleado, 200, [], ['groups' => 'empleado:read']);
    }

    #[Route('/{id}', name: 'empleados_delete', methods: ['DELETE'])]
    public function delete(Empleado $empleado, EntityManagerInterface $em): JsonResponse
    {
        $this->denyUnlessGrantedEmpresa($empleado);

        $em->remove($empleado);
        $em->flush();

        return $this->json(null, 204);
    }

    private function denyUnlessGrantedEmpresa(Empleado $empleado): void
    {
        if ($empleado->getEmpresa()->getId() !== $this->getUser()->getEmpresa()->getId()) {
            throw $this->createAccessDeniedException();
        }
    }
}
