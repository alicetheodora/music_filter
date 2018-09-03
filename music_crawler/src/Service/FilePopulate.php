<?php

namespace App\Service;

use App\Entity\MP3File;
use App\Entity\MP3Metadata as MD;
use App\Entity\MP3Blob as MB;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FilePopulate
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }


    public function populate(MP3File $entity)
    {
        $getID3 = new \getID3;
        $tags=$getID3->analyze($entity->getFullpath());

        $meta = new MD;
        $blob = new MB;


        if($entity instanceof MP3File)
        {
            $meta->setTitle(implode($tags['tags']['id3v2']['title']));
            $meta->setAlbum(implode($tags['tags']['id3v2']['album']));
            $meta->setArtist(implode($tags['tags']['id3v2']['artist']));
            $meta->setBitrate($tags['bitrate']);
            $meta->setYear(implode($tags['tags']['id3v2']['year']));
            $meta->setGenre(implode($tags['tags']['id3v2']['genre']));
            $meta->setTrack(implode($tags['tags']['id3v2']['track_number']));
            $meta->setDuration(intval($tags['playtime_string']));
            $entity->setMp3metadata($meta);

            $concat=$meta->getTitle().$meta->getArtist().$meta->getAlbum().$meta->getYear().$meta->getDuration().$meta->getGenre().$meta->getTrack().$meta->getComment().$meta->getBitrate().$meta->getPopularityMeter().$meta->getUniqueFileIdentifier();
            $blob->setMetadata($concat);
            $entity->setMp3blob($blob);

        }


        return $entity;
    }


    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

}