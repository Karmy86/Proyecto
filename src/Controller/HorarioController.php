<?php

namespace App\Controller;

use App\Repository\HorarioEneroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use App\Entity\Pacientes;
use App\Repository\PacientesRepository;

#[Route('/horario')]
class HorarioController extends AbstractController
{
    private HorarioEneroRepository $horariosRepository;

    public function __construct(HorarioEneroRepository $horariosRepo)
    {
        $this->horariosRepository = $horariosRepo;
    }

    #[Route('/', name: 'app_horario', methods: ['GET', 'POST'])]
    public function index(HorarioEneroRepository $horariosRepository): JsonResponse
    {
        $horarios = $horariosRepository->findAll();
        $data = array();
        foreach ($horarios as $key => $value)
            $data[$key] = [
                'id' => $value->getId(),
                'dia' => $value->getDia(),
                'hora' => $value->getHora()->format('H:i:s'),
                'estado' => $value->isEstado(),
                'id_paciente' => $value->getIdPaciente()
            ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/nuevaReserva', name: 'app_horario_new', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent());

        $this->horariosRepository->new(new DateTime($data->dia), new DateTime($data->hora), $data->estado, $data->id_paciente);

        return new JsonResponse(['status' => 'reserva creada'], Response::HTTP_CREATED);
    }

    #[Route('/diasDisponibles', name: 'app_dias_dispo', methods: ['POST'])]
    public function mostrarDiasDispo(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $diasDisponibles = $this->horariosRepository->getAvailableDays($data);

        return new JsonResponse($diasDisponibles, Response::HTTP_OK);
    }

    #[Route('/horasDisponibles/{dia}', name: 'app_horas_dispo', methods: ['POST'])]
    public function horasDisponibles(DateTime $dia): JsonResponse
    {
        $diaDispo = $this->horariosRepository->findBy(['dia' => $dia]);

        $data = array();
        foreach ($diaDispo as $key => $value){
            if ($value !== null){
                $data[$key] = [
                    //'id' => $value->getId(),
                    //'dia' => $value->getDia()->format('d-m-Y'),
                    'hora' => $value->getHora()->format('H:i:s')
                    //'estado' => $value->isEstado(),
                    //'id_paciente_id' => $value->getIdPaciente()
                ];
            }
        }

        /* $horasDisponibles = [];
        foreach ($diaDispo as $key => $value) {
            if ($value !== null && $value->isEstado() == true && $value->getIdPaciente() == null) {
                $horasDisponibles[] = $value->getHora()->format('H:i:s');
            }
        } */


        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/reservarHora/{dia}/{hora}', name: 'app_reservar_hora', methods: ['POST'])]
    public function reservarHora(DateTime $dia, DateTime $hora, Request $request, PacientesRepository $pacientesRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $idPaciente = $data['id_paciente'];
        $paciente = $pacientesRepository->find($idPaciente);

        $this->horariosRepository->bookTime($dia, $hora, $paciente);

        return new JsonResponse(['status' => 'Hora reservada con éxito'], Response::HTTP_CREATED);
    }
}
