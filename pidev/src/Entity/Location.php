<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=LocationRepository::class)
 */
class Location
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     *  @Assert\Range(
     *      min = 1,
     *      notInRangeMessage = "quantite doit etre minimum 1",
     * )
     */
    private $quantite;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDeb;

    /**
     * @ORM\Column(type="date")
     */
    private $dateFin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDateDeb(): ?\DateTimeInterface
    {
        return $this->dateDeb;
    }

    public function setDateDeb(\DateTimeInterface $dateDeb): self
    {
        $this->dateDeb = $dateDeb;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

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
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_Produit", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idProduit;


    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }


    public function setIdUser(?Users $idUser): void
    {
        $this->idUser = $idUser;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }


    public function setIdProduit(?Produit $idProduit): void
    {
        $this->idProduit = $idProduit;
    }



}
