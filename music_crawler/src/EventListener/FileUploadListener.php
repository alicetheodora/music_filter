<?php

namespace App\EventListener;

use App\Service\FilePopulate;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use App\Entity\MP3File;
use App\Service\FileUploader;


class FileUploadListener
{
    private $uploader;

    private $filesystem;

    private $populate;

    public function __construct(FileUploader $uploader, Filesystem $filesystem, FilePopulate $ppulate)
    {
        $this->uploader = $uploader;
        $this->filesystem = $filesystem;
        $this->populate= $ppulate;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Mp3file entities
        if (!$entity instanceof MP3File) {
            return;
        }

        /** @var UploadedFile $file */
        $file = $entity->getUploadedFile();

        // only upload new files
        if ($file instanceof UploadedFile)
        {
            $fileName = $this->uploader->upload($file);
            $entity->setUploadedFile($fileName);
            $entity->setFullpath($this->uploader->getTargetDirectory()."/{$fileName}");
            $full=$this->uploader->getTargetDirectory()."/{$fileName}";
            $entity->setBasename($file->getClientOriginalName());
            $this->populate->populate($entity);


        }
        elseif ($file instanceof File)
        {

            $entity->setUploadedFile($file->getFilename());
            $entity->setFullpath($this->uploader->getTargetDirectory()."/{$file->getFilename()}");
            $entity->setBasename($file->getFilename());
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof MP3File) {
            return;
        }

        if ($fileName = $entity->getUploadedFile()) {
            $entity->setUploadedFile(new File($this->uploader->getTargetDirectory().'/'.$fileName));
        }
    }

    public function  preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof MP3File) {
            return;
        }

        /** @var File $file */
        if ($file = $entity->getUploadedFile()) {
            $this->filesystem->remove((string) $entity->getUploadedFile());
        }
    }


}