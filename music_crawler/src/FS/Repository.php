<?php


namespace App\FS;

class Repository {

    private $servername;
    private $dbname;
    private $username;
    private $password;

    public function __construct($servername, $dbname, $username, $password) {

        $this->servername = $servername;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;

    }

    public function saveFile(File $file) : void {

        try{

            $conn = new \PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $insertStatement = $conn->prepare('INSERT INTO MP3Files 
                      (fullpath, basename)
                      VALUES (:fullpath, :basename)');

            $insertStatement->execute(array(
                ":fullpath" => $file->getPath(),
                ":basename" => $file->getName()
            ));

        } catch(\PDOException $e) {
            echo "saveFile: " . $e->getMessage() . "\n";
        }

    }

    public function saveMP3Metadata(File $file) : void {
        try {

            $conn = new \PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $selectStatement = $conn->prepare('SELECT id FROM MP3Files WHERE fullpath = :path;');

            $selectStatement->execute(
                array(":path" => $file->getPath())
            );

            $idMP3File = $selectStatement->fetchAll(\PDO::FETCH_COLUMN);

            $idMP3File = implode($idMP3File);

            $metadata = $file->getMetadata();

            $metadata->analyze();

            $tagArray = $metadata->getTagArray();

            $insertStatement =  $conn->prepare('INSERT INTO MP3Metadata 
                        (id_mp3file, title, artist, album, duration, year, genre, comment, 
                        contributor, bitrate, track, popularityMeter, uniqueFileIdentifier)
                        VALUES (:foreignkey, :title, :artist, :album, :duration, :year, :genre, :comment,
                        :contributor, :bitrate, :track, :popularityMeter, :uniqueFileIdentifier);');

            $insertStatement->execute(array(
                ":foreignkey" => $idMP3File,
                ":title" => $tagArray[0],
                ":artist" => $tagArray[1],
                ":album" => $tagArray[2],
                ":duration" => $tagArray[3],
                ":year" => $tagArray[4],
                ":genre" => $tagArray[5],
                ":comment" => $tagArray[6],
                ":contributor" => $tagArray[7],
                "bitrate" => $tagArray[8],
                ":track" => $tagArray[9],
                ":popularityMeter" => $tagArray[10],
                ":uniqueFileIdentifier" => $tagArray[11]
            ));

        } catch(\PDOException $e) {
            echo "saveMP3Metadata: " . $e->getMessage() . "\n";
        }

    }

    public function saveMP3MetadataBlob(File $file) : void {

        try {

            $conn = new \PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $fullpath = $file->getPath();


            $selectStatement = $conn->prepare("SELECT id FROM MP3Files WHERE fullpath = :fullpath");

            $selectStatement->execute(array(":fullpath"=>$fullpath));

            $idMP3File = $selectStatement->fetchAll(\PDO::FETCH_COLUMN);

            $idMP3File = implode($idMP3File);

            $metadataArray = $conn->prepare("select artist,album,title,duration,year,genre,comment,track FROM MP3Metadata where id_mp3file = :idMP3File");
            $metadataArray->execute(array(":idMP3File"=>$idMP3File));

            $concatMetadata = $metadataArray->fetchAll();

            $concatMetadata = $concatMetadata[0];

            $len = count($concatMetadata);

            $blobString = "";

            for ($it = 0; $it < $len; ++$it) {
                if(isset($concatMetadata[$it])) {
                    $blobString .= $concatMetadata[$it];
                }
            }

            $insertStatement =  $conn->prepare('INSERT INTO MP3MetadataBlob  
                                (id_mp3file, blobstring)
                                VALUES (:foreignkey, :blobstring);');

            $insertStatement->execute(array(
                ":foreignkey" => $idMP3File,
                ":blobstring" => $blobString
            ));

        } catch(\PDOException $e) {
            echo "saveMP3MetadataBlob: " . $e->getMessage() . "\n";
        }

    }


}