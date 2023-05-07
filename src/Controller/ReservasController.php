<?php

namespace App\Controller;

use App\Repository\ReservasRepository;
use App\Repository\PacientesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pacientes;
use App\Entity\Reservas;
use DateTime;
use DateTimeImmutable;


#[Route('/reservas')]
class ReservasController extends AbstractController
{
    private ReservasRepository $reservasRepository;
    private PacientesRepository $pacientesRepository;

    public function __construct(ReservasRepository $reservasRepo, PacientesRepository $pacientesRepo)
    {
        $this->reservasRepository = $reservasRepo;
        $this->pacientesRepository = $pacientesRepo;
    }

    #[Route('/listar', name: 'api_listar_reservas_por_semana', methods: ['GET'])]
    public function listByWeek(Request $request, ReservasRepository $reservasRepository): JsonResponse
    {
        $from = $this->formatDateTime($request->query->get('from'));
        $to = $this->formatDateTime($request->query->get('to'));
        $reservas = $reservasRepository->findAllByWeek($from, $to);
        // echo count($reservas);
        foreach ($reservas as $key => $value)
            $reservas[$key] = [
                'id' => $value->getId(),
                'dia_hora' => $value->getDiaHora()
            ];

        return new JsonResponse($reservas, Response::HTTP_OK);
    }

    #[Route('/listar/paciente', name: 'api_listar_reservas_por_semana_paciente', methods: ['GET', 'POST'])]
    public function listByWeekPatient(Request $request, ReservasRepository $reservasRepository): JsonResponse
    {
        $patientId = $request->query->get('patientId');
        $from = $this->formatDateTime($request->query->get('from'));
        $to = $this->formatDateTime($request->query->get('to'));

        $reservas = $reservasRepository->findAllByWeekAndPatient($from, $to, $patientId);
        // echo count($reservas);
        foreach ($reservas as $key => $value)
            $reservas[$key] = [
                'id' => $value->getId(),
                'dia_hora' => $value->getDiaHora()->format('Y-m-d H:i:s')
            ];
        return new JsonResponse($reservas, Response::HTTP_OK);
    }
    

    #[Route('/nueva', name: 'api_nueva_reserva', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        //$timezone = new \DateTimeZone('Europe/Madrid');
        $dia_hora = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['dia_hora'], null);
        //$dia_hora = $dia_hora->setTimezone(new \DateTimeZone('UTC'));
        echo $dia_hora->format('Y-m-d H:i:s');
    
        $paciente = $this->pacientesRepository->find($data['id_paciente']);

        $reserva = $this->reservasRepository->new($dia_hora, $paciente);
        
        return new JsonResponse($reserva, Response::HTTP_CREATED);
    }

    private function formatDateTime(string $inputDateTime): DateTimeImmutable {
        return DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $inputDateTime, null);
    }

}
