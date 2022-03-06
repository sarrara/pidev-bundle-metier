<?php

namespace App\Entity;

use App\Repository\RandonneeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=RandonneeRepository::class)
 * @Vich\Uploadable
*/
class randonnee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     *@Assert\NotBlank
     * @ORM\Column(type="float")
     */
    private $prix;
    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $localisation;

    /**
     * @Assert\Range(
     *      min = 1,
     * 
     *      notInRangeMessage = "You must be bigger than 0 to enter",
     * )
     * @ORM\Column(type="integer")
     */
    private $nbrPlace ;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_deb", type="date", nullable=false)
     */
    private $dateDeb;

    /**
     * @var \Activitie
     *
     * @ORM\ManyToOne(targetEntity="Activitie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_activ", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idActivite;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="rondoneimage", fileNameProperty="image")
     *
     * @var File|null
     */
    public  $file;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    public function getWebpath(){


        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../nouveau/public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->image = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->image = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    private $nb_participation;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param mixed $localisation
     */
    public function setLocalisation($localisation): void
    {
        $this->localisation = $localisation;
    }

    /**
     * @return \DateTime
     */
    public function getDateDeb(): ?\DateTime
    {
        return $this->dateDeb;
    }

    /**
     * @param \DateTime $dateDeb
     */
    public function setDateDeb(\DateTime $dateDeb): void
    {
        $this->dateDeb = $dateDeb;
    }

    /**
     * @return mixed
     */
    public function getNbParticipation()
    {
        return $this->nb_participation;
    }

    /**
     * @param mixed $nb_participation
     */
    public function setNbParticipation($nb_participation): void
    {
        $this->nb_participation = $nb_participation;
    }

    /**
     * @return mixed
     */
    public function getNbrPlace()
    {
        return $this->nbrPlace;
    }

    /**
     * @param mixed $nbrPlace
     */
    public function setNbrPlace($nbrPlace): void
    {
        $this->nbrPlace = $nbrPlace;
    }


    public function getIdActivite():?Activitie
    {
        return $this->idActivite;
    }


    public function setIdActivite(?Activitie $idActivite): void
    {
        $this->idActivite = $idActivite;
    }




}
