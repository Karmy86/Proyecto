<?php

namespace App\Controller;

/* header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
header("Content-Type: application/json"); */

use App\Repository\PacientesRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pacientes;

#[Route('/pacientes')]
class PacientesController extends AbstractController
{
    private PacientesRepository $pacientesRepository;

    public function __construct(PacientesRepository $pacientesRep)
    {
        $this->pacientesRepository = $pacientesRep;
    }

    #[Route('/', name: 'api_pacientes_index', methods: ['GET', 'POST'])]
    public function index(PacientesRepository $pacientesRepository): JsonResponse
    {
        $pacientes = $pacientesRepository->findAll();
        $data = array();
        foreach ($pacientes as $key => $value)
            $data[$key] = [
                'id' => $value->getId(),
                'nombre' => $value->getNombre(),
                'apellidos' => $value->getApellidos(),
                'fecha_nacimiento' => $value->getFechaNacimiento(),
                'telefono' => $value->getTelefono(),
                'email' => $value->getEmail(),
                'observaciones' => $value->getObservaciones()
            ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/new', name: 'api_pacientes_new', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        $this->pacientesRepository->new($data->nombre, $data->apellidos, new DateTime($data->fecha_nacimiento), $data->telefono, $data->email, $data->observaciones);

        return new JsonResponse(['status' => 'Paciente creado'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'api_pacientes_show', methods: ['GET'])]
    public function show(Pacientes $paciente): JsonResponse
    {
        $data = [
            'id' => $paciente->getId(),
            'nombre' => $paciente->getNombre(),
            'apellidos' => $paciente->getApellidos(),
            'fecha_nacimiento' => $paciente->getFechaNacimiento(),
            'telefono' => $paciente->getTelefono(),
            'email' => $paciente->getEmail(),
            'observaciones' => $paciente->getObservaciones()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/edit/{id}', name: 'api_pacientes_edit', methods: ['PUT', 'PATCH'])]
    public function edit($id, Request $request): JsonResponse
    {
        $paciente = $this->pacientesRepository->find($id);
        $data = json_decode($request->getContent());
        if ($_SERVER['REQUEST_METHOD'] == 'PUT')
            $mensaje = 'Paciente completamente actualizado de forma satisfactoria';
        else
            $mensaje = 'Paciente parcialmente actualizado de forma satisfactoria';
        empty($data->nombre) ? true : $paciente->setNombre($data->nombre);
        empty($data->apellidos) ? true : $paciente->setApellidos($data->apellidos);
        empty($data->fecha_nacimiento) ? true : $paciente->setFechaNacimiento(new DateTime($data->fecha_nacimiento));
        empty($data->telefono) ? true : $paciente->setTelefono($data->telefono);
        empty($data->email) ? true : $paciente->setEmail($data->email);
        empty($data->observaciones) ? true : $paciente->setObservaciones($data->observaciones);
        $this->pacientesRepository->save($paciente, true);

        return new JsonResponse(['status' => $mensaje], Response::HTTP_CREATED);
    }

    #[Route('/delete/{id}', name: 'api_pacientes_delete', methods: ['DELETE'])]
    public function remove(Pacientes $paciente): JsonResponse
    {
        $email = $paciente->getEmail();
        $this->pacientesRepository->remove($paciente, true);

        return new JsonResponse(['status' => 'Paciente ' . $email . ' borrado'], Response::HTTP_OK);
    }
}
