<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass=SponsorRepository::class)
 */
class Sponsor
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
     *
     * @ORM\Column(type="string", length=255)
     */
    private $contrat;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getContrat(): ?string
    {
        return $this->contrat;
    }

    public function setContrat(string $contrat): self
    {
        $this->contrat = $contrat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $file;


    public function getWebpath(){


        return null === $this->contrat ? null : $this->getUploadDir().'/'.$this->contrat;
    }
    protected  function  getUploadRootDir(){

        return __DIR__.'/../../../nouveau/public/Upload'.$this->getUploadDir();
    }
    protected function getUploadDir(){

        return'';
    }
    public function getUploadFile(){
        if (null === $this->getFile()) {
            $this->contrat = "3.jpg";
            return;
        }


        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->contrat = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
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
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Assert\File(maxSize="500000000k")
     */
    public  $fileimage;


    public function getWebpathImage(){


        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }
    protected  function  getUploadRootDirImage(){

        return __DIR__.'/../../../nouveau/public/Upload'.$this->getUploadDir();
    }
    public function getUploadFileImage(){
        if (null === $this->getFileimage()) {
            $this->image = "3.jpg";
            return;
        }


        $this->getFileimage()->move(
            $this->getUploadRootDir(),
            $this->getFileimage()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->image = $this->getFileimage()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->fileimage = null;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getFileimage()
    {
        return $this->fileimage;
    }

    /**
     * @param mixed $fileimage
     */
    public function setFileimage($fileimage): void
    {
        $this->fileimage = $fileimage;
    }


}
