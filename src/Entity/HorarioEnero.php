<?php

namespace App\Entity;

use App\Repository\HorarioEneroRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HorarioEneroRepository::class)]
class HorarioEnero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dia = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hora = null;

    #[ORM\Column]
    private ?bool $estado = null;

    #[ORM\ManyToOne(inversedBy: 'horarioEneros')]
    private ?Pacientes $id_paciente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDia(): ?\DateTimeInterface
    {
        return $this->dia;
    }

    public function setDia(\DateTimeInterface $dia): self
    {
        $this->dia = $dia;

        return $this;
    }

    public function getHora(): ?\DateTimeInterface
    {
        return $this->hora;
    }

    public function setHora(\DateTimeInterface $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function isEstado(): ?bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): self
    {
        $this->estado = $estado;

        return $this;
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
}
