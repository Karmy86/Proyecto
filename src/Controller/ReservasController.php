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
    

    #[Route('/nueva', name: 'api_nueva_reserva', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $timezone = new \DateTimeZone('Europe/Berlin');
        $dia_hora = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['dia_hora'], $timezone);
        $dia_hora = $dia_hora->setTimezone(new \DateTimeZone('UTC'));
    
        $paciente = $this->pacientesRepository->find($data['id_paciente']);

        $reserva = $this->reservasRepository->new($dia_hora, $paciente);
        
        return new JsonResponse($reserva, Response::HTTP_CREATED);

    }
    
}
