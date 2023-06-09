<?php

namespace App\Entity;

use App\Repository\PacientesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Unique;

#[ORM\Entity(repositoryClass: PacientesRepository::class)]
class Pacientes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $nombre = null;

    #[ORM\Column(length: 40)]
    private ?string $apellidos = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_nacimiento = null;

    #[ORM\Column]
    private ?int $telefono = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'id_paciente', targetEntity: HorarioEnero::class)]
    private Collection $horarioEneros;

    #[ORM\OneToMany(mappedBy: 'id_paciente', targetEntity: Reservas::class)]
    private Collection $reservas;

    public function __construct()
    {
        $this->horarioEneros = new ArrayCollection();
        $this->reservas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    public function setTelefono(int $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, HorarioEnero>
     */
    public function getHorarioEneros(): Collection
    {
        return $this->horarioEneros;
    }

    public function addHorarioEnero(HorarioEnero $horarioEnero): self
    {
        if (!$this->horarioEneros->contains($horarioEnero)) {
            $this->horarioEneros->add($horarioEnero);
            $horarioEnero->setIdPaciente($this);
        }

        return $this;
    }

    public function removeHorarioEnero(HorarioEnero $horarioEnero): self
    {
        if ($this->horarioEneros->removeElement($horarioEnero)) {
            // set the owning side to null (unless already changed)
            if ($horarioEnero->getIdPaciente() === $this) {
                $horarioEnero->setIdPaciente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservas>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reservas $reserva): self
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas->add($reserva);
            $reserva->setIdPaciente($this);
        }

        return $this;
    }

    public function removeReserva(Reservas $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getIdPaciente() === $this) {
                $reserva->setIdPaciente(null);
            }
        }

        return $this;
    }
}
