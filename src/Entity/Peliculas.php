<?php

namespace App\Entity;

use App\Repository\PeliculasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PeliculasRepository::class)]
class Peliculas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_publicacion = null;

    #[ORM\Column(length: 255)]
    private ?string $genero = null;

    #[ORM\Column(nullable: true)]
    private ?int $duracion = null;

    #[ORM\Column(length: 255)]
    private ?string $productora = null;

    #[ORM\OneToMany(mappedBy: 'peliculas', targetEntity: Actor::class)]
    private Collection $actor;

    #[ORM\OneToMany(mappedBy: 'peliculas', targetEntity: Director::class)]
    private Collection $director;

    public function __construct()
    {
        $this->actor = new ArrayCollection();
        $this->director = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(?\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getProductora(): ?string
    {
        return $this->productora;
    }

    public function setProductora(string $productora): self
    {
        $this->productora = $productora;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActor(): Collection
    {
        return $this->actor;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actor->contains($actor)) {
            $this->actor[] = $actor;
            $actor->setPeliculas($this);
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        if ($this->actor->removeElement($actor)) {
            // set the owning side to null (unless already changed)
            if ($actor->getPeliculas() === $this) {
                $actor->setPeliculas(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Director>
     */
    public function getDirector(): Collection
    {
        return $this->director;
    }

    public function addDirector(Director $director): self
    {
        if (!$this->director->contains($director)) {
            $this->director[] = $director;
            $director->setPeliculas($this);
        }

        return $this;
    }

    public function removeDirector(Director $director): self
    {
        if ($this->director->removeElement($director)) {
            // set the owning side to null (unless already changed)
            if ($director->getPeliculas() === $this) {
                $director->setPeliculas(null);
            }
        }

        return $this;
    }
}
