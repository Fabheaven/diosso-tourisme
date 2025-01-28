<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128233443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wishlist_circuit (wishlist_id INT NOT NULL, circuit_id INT NOT NULL, INDEX IDX_8C2925DCFB8E54CD (wishlist_id), INDEX IDX_8C2925DCCF2182C8 (circuit_id), PRIMARY KEY(wishlist_id, circuit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE wishlist_circuit ADD CONSTRAINT FK_8C2925DCFB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist_circuit ADD CONSTRAINT FK_8C2925DCCF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity ADD description LONGTEXT DEFAULT NULL, ADD price NUMERIC(10, 2) DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('DROP INDEX IDX_BA388B7A76ED395 ON cart');
        $this->addSql('ALTER TABLE cart ADD quantity INT NOT NULL, ADD cart_id INT NOT NULL, ADD circuit_id INT DEFAULT NULL, ADD activity_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B71AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7CF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id)');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B781C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_BA388B71AD5CDBF ON cart (cart_id)');
        $this->addSql('CREATE INDEX IDX_BA388B7CF2182C8 ON cart (circuit_id)');
        $this->addSql('CREATE INDEX IDX_BA388B781C06096 ON cart (activity_id)');
        $this->addSql('ALTER TABLE circuit ADD duration INT NOT NULL, ADD image VARCHAR(255) NOT NULL, ADD availability TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wishlist_circuit DROP FOREIGN KEY FK_8C2925DCFB8E54CD');
        $this->addSql('ALTER TABLE wishlist_circuit DROP FOREIGN KEY FK_8C2925DCCF2182C8');
        $this->addSql('DROP TABLE wishlist_circuit');
        $this->addSql('ALTER TABLE activity DROP description, DROP price, DROP image');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B71AD5CDBF');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7CF2182C8');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B781C06096');
        $this->addSql('DROP INDEX IDX_BA388B71AD5CDBF ON cart');
        $this->addSql('DROP INDEX IDX_BA388B7CF2182C8 ON cart');
        $this->addSql('DROP INDEX IDX_BA388B781C06096 ON cart');
        $this->addSql('ALTER TABLE cart ADD user_id CHAR(36) NOT NULL, DROP quantity, DROP cart_id, DROP circuit_id, DROP activity_id');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('ALTER TABLE circuit DROP duration, DROP image, DROP availability');
    }
}
