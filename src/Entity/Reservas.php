<?php

namespace App\Entity;

use App\Repository\ReservasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservasRepository::class)]
class Reservas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, unique:true)]
    private ?\DateTimeInterface $dia_hora = null;

    #[ORM\ManyToOne(inversedBy: 'reservas', targetEntity:Pacientes::class)]
    #[ORM\JoinColumn(nullable: false, name:'id_paciente', referencedColumnName:'id')]
    private ?Pacientes $id_paciente = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIdPaciente(): ?Pacientes
    {
        return $this->id_paciente;
    }

    public function setIdPaciente(?Pacientes $id_paciente): self
    {
        $this->id_paciente = $id_paciente;

        return $this;
    }

    /**
     * Get the value of dia_hora
     */
    public function getDiaHora(): ?\DateTimeInterface
    {
        return $this->dia_hora;
    }

    /**
     * Set the value of dia_hora
     */
    public function setDiaHora(?\DateTimeInterface $dia_hora): self
    {
        $this->dia_hora = $dia_hora;

        return $this;
    }
}
