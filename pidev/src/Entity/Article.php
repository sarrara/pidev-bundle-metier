<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 *
 */
class Article
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
    private $titre;

    /**
     *
     * @ORM\Column(type="date")
     */
    private $dateEcrit;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Your Description name must be at least {{ limit }} characters long",
     * )
     */

    private $description;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDateEcrit(): ?\DateTimeInterface
    {
        return $this->dateEcrit;
    }

    public function setDateEcrit(\DateTimeInterface $dateEcrit): self
    {
        $this->dateEcrit = $dateEcrit;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;



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

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }


    public function setIdUser(?Users $idUser): void
    {
        $this->idUser = $idUser;
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
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat): void
    {
        $this->etat = $etat;
    }




}
