<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActorRepository::class)]
class Actor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_nacimiento = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_fallecimiento = null;

    #[ORM\Column(length: 255)]
    private ?string $lugar_nacimiento = null;

    #[ORM\ManyToOne(inversedBy: 'actor')]
    private ?Peliculas $peliculas = null;

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

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
    }

    public function getFechaFallecimiento(): ?\DateTimeInterface
    {
        return $this->fecha_fallecimiento;
    }

    public function setFechaFallecimiento(\DateTimeInterface $fecha_fallecimiento): self
    {
        $this->fecha_fallecimiento = $fecha_fallecimiento;

        return $this;
    }

    public function getLugarNacimiento(): ?string
    {
        return $this->lugar_nacimiento;
    }

    public function setLugarNacimiento(string $lugar_nacimiento): self
    {
        $this->lugar_nacimiento = $lugar_nacimiento;

        return $this;
    }

    public function getPeliculas(): ?Peliculas
    {
        return $this->peliculas;
    }

    public function setPeliculas(?Peliculas $peliculas): self
    {
        $this->peliculas = $peliculas;

        return $this;
    }
}
