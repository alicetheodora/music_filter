<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180831105120 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mp3blob (id INT AUTO_INCREMENT NOT NULL, metadata VARCHAR(255) DEFAULT NULL, blobstring VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mp3file (id INT AUTO_INCREMENT NOT NULL, mp3metadata_id INT DEFAULT NULL, mp3blob_id INT DEFAULT NULL, fullpath VARCHAR(255) NOT NULL, basename VARCHAR(255) NOT NULL, uploaded_file VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3775D4C084C64670 (mp3metadata_id), UNIQUE INDEX UNIQ_3775D4C04C202126 (mp3blob_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mp3metadata (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, artist VARCHAR(255) DEFAULT NULL, album VARCHAR(255) DEFAULT NULL, duration INT DEFAULT NULL, year INT DEFAULT NULL, genre VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, contributor VARCHAR(255) DEFAULT NULL, bitrate INT DEFAULT NULL, track INT DEFAULT NULL, popularity_meter VARCHAR(255) DEFAULT NULL, unique_file_identifier INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mp3file ADD CONSTRAINT FK_3775D4C084C64670 FOREIGN KEY (mp3metadata_id) REFERENCES mp3metadata (id)');
        $this->addSql('ALTER TABLE mp3file ADD CONSTRAINT FK_3775D4C04C202126 FOREIGN KEY (mp3blob_id) REFERENCES mp3blob (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE mp3file DROP FOREIGN KEY FK_3775D4C04C202126');
        $this->addSql('ALTER TABLE mp3file DROP FOREIGN KEY FK_3775D4C084C64670');
        $this->addSql('DROP TABLE mp3blob');
        $this->addSql('DROP TABLE mp3file');
        $this->addSql('DROP TABLE mp3metadata');
    }
}
