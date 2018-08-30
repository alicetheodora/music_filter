<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MP3BlobRepository")
 */
class MP3Blob
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metadata;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $blobstring;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMetadata(): ?string
    {
        return $this->metadata;
    }

    public function setMetadata(?string $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function getBlobstring(): ?string
    {
        return $this->blobstring;
    }

    public function setBlobstring(?string $blobstring): self
    {
        $this->blobstring = $blobstring;

        return $this;
    }
    public  function  __toString()
    {
       return (string)$this->metadata;
    }

}
