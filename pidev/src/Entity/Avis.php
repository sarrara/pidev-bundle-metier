<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AvisRepository::class)
 */
class Avis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rate;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etoile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Reservation::class, inversedBy="avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(?string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getEtoile(): ?int
    {
        return $this->etoile;
    }

    public function setEtoile(?int $etoile): self
    {
        $this->etoile = $etoile;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReservation(): ?reservation
    {
        return $this->reservation;
    }

    public function setReservation(?reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}
