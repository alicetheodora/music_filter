<?php

namespace App\Service;

use App\FS\MP3File;
use App\FS\MP3Metadata;

class FilePopulate
{

    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function populate($path):array
    {
        $file= new MP3File ($path);

        $meta= $file->getMetadata();
        $meta->analyze();

        $tags = $meta->getTagArray();
        $this->setFullpath($meta->getPath());
        $this->setBasename($meta->getName());
        $metadata = $meta->getMp3Metadata();
        $metadata->setAlbum($tags['album']);
        $metadata->setArtist($tags['artist']);
        $metadata->setTitle($tags['title']);
        $metadata->setDuration($tags['duration']);
        $metadata->setYear($tags['year']);
        $metadata->setGenre($tags['genre']);
        $metadata->setComment($tags['comment']);
        $metadata->setTrack($tags['track']);
        $metadata->setContributor($tags['contributor']);
        $metadata->setBitrate($tags['bitrate']);
        $metadata->setPopularityMeter($tags['popularityMeter']);
        $metadata->setUniqueFileIdentifier($tags['ufi']);
        $concatMeta = '';

        foreach ($tags as $tag) {
            $concatMeta .= $tag;
        }

        return $this->getMp3Metadata()->getMp3Blob()->setConcatMetadata($concatMeta);

    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}