<?php

namespace App\Entity;

use App\FS\Node;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Finder\Finder as Finder;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MP3FileRepository")
 */
class MP3File
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $fullpath;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $basename;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MP3Metadata", cascade={"persist", "remove"})
     */
    private $mp3metadata;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MP3Blob", cascade={"persist", "remove"})
     */
    private $mp3blob;

    /**
     * @var null|string|File|UploadedFile
     *
     * @ORM\Column(type="string", length=255)
     */
    private $uploadedFile;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullpath(): ?string
    {
        return $this->fullpath;
    }

    public function setFullpath(string $fullpath): self
    {
        $this->fullpath = $fullpath;

        return $this;
    }

    public function getBasename(): ?string
    {
        return $this->basename;
    }

    public function setBasename(string $basename): self
    {
        $this->basename = $basename;

        return $this;
    }

    public function getMp3metadata(): ?MP3Metadata
    {
        return $this->mp3metadata;
    }

    public function setMp3metadata(?MP3Metadata $mp3metadata): self
    {
        $this->mp3metadata = $mp3metadata;

        return $this;
    }

    public function getMp3blob(): ?MP3Blob
    {
        return $this->mp3blob;
    }

    public function setMp3blob(?MP3Blob $mp3blob): self
    {
        $this->mp3blob = $mp3blob;

        return $this;
    }

    /**
     * @return null|string|File|UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param null|string|File|UploadedFile $uploadedFile
     *
     * @return MP3File
     */
    public function setUploadedFile($uploadedFile): self
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }



}
