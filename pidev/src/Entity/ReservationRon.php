<?php

namespace App\Entity;

use App\Repository\ReservationRonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ReservationRonRepository::class)
 */
class ReservationRon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Range(
     *      min = 1,
     *     max=10,
     *      notInRangeMessage = "nombre de personnes doit étre superieur à 0 et ne doit pas dépasser 10 places ",
     * )
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $nbrPersonne;

    /**
     * @ORM\Column(type="boolean")
     */
    private $transport;

    /**
     * @ORM\Column(type="boolean")
     */
    private $nourriture;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_User", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idUser;


    /**
     * @var \randonnee
     *
     * @ORM\ManyToOne(targetEntity="randonnee")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_randonnee", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idron;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbrPersonne(): ?int
    {
        return $this->nbrPersonne;
    }

    public function setNbrPersonne(int $nbrPersonne): self
    {
        $this->nbrPersonne = $nbrPersonne;

        return $this;
    }

    public function getTransport(): ?bool
    {
        return $this->transport;
    }

    public function setTransport(bool $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getNourriture(): ?bool
    {
        return $this->nourriture;
    }

    public function setNourriture(bool $nourriture): self
    {
        $this->nourriture = $nourriture;

        return $this;
    }


    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }


    public function setIdUser(?Users $idUser): void
    {
        $this->idUser = $idUser;
    }


    public function getIdron(): ?randonnee
    {
        return $this->idron;
    }


    public function setIdron(?randonnee $idron): void
    {
        $this->idron = $idron;
    }


}
