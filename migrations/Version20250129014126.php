<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250129014126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_file (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE activity ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD state VARCHAR(255) NOT NULL, ADD mediafile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AD6810431 FOREIGN KEY (mediafile_id) REFERENCES media_file (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC74095AD6810431 ON activity (mediafile_id)');
        $this->addSql('ALTER TABLE circuit ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD state VARCHAR(255) NOT NULL, ADD mediafile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE circuit ADD CONSTRAINT FK_1325F3A6D6810431 FOREIGN KEY (mediafile_id) REFERENCES media_file (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1325F3A6D6810431 ON circuit (mediafile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE media_file');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AD6810431');
        $this->addSql('DROP INDEX UNIQ_AC74095AD6810431 ON activity');
        $this->addSql('ALTER TABLE activity DROP created_at, DROP updated_at, DROP state, DROP mediafile_id');
        $this->addSql('ALTER TABLE circuit DROP FOREIGN KEY FK_1325F3A6D6810431');
        $this->addSql('DROP INDEX UNIQ_1325F3A6D6810431 ON circuit');
        $this->addSql('ALTER TABLE circuit DROP created_at, DROP updated_at, DROP state, DROP mediafile_id');
    }
}
