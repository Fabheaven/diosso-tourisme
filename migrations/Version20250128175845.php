<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128175845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE activity_user (activity_id INT NOT NULL, user_id CHAR(36) NOT NULL, INDEX IDX_8E570DDB81C06096 (activity_id), INDEX IDX_8E570DDBA76ED395 (user_id), PRIMARY KEY(activity_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE cart (id INT AUTO_INCREMENT NOT NULL, user_id CHAR(36) NOT NULL, INDEX IDX_BA388B7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE cart_item (id INT AUTO_INCREMENT NOT NULL, item_type VARCHAR(255) NOT NULL, item_id INT NOT NULL, quantity INT NOT NULL, cart_id INT NOT NULL, INDEX IDX_F0FE25271AD5CDBF (cart_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE circuit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE circuit_activity (circuit_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_7C29C2FBCF2182C8 (circuit_id), INDEX IDX_7C29C2FB81C06096 (activity_id), PRIMARY KEY(circuit_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE circuit_user (circuit_id INT NOT NULL, user_id CHAR(36) NOT NULL, INDEX IDX_E46BB0B4CF2182C8 (circuit_id), INDEX IDX_E46BB0B4A76ED395 (user_id), PRIMARY KEY(circuit_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, author_id CHAR(36) NOT NULL, circuit_id INT DEFAULT NULL, activity_id INT DEFAULT NULL, INDEX IDX_9474526CF675F31B (author_id), INDEX IDX_9474526CCF2182C8 (circuit_id), INDEX IDX_9474526C81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, user_id CHAR(36) NOT NULL, INDEX IDX_97DE5E23A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pack_circuit (pack_id INT NOT NULL, circuit_id INT NOT NULL, INDEX IDX_286C63DB1919B217 (pack_id), INDEX IDX_286C63DBCF2182C8 (circuit_id), PRIMARY KEY(pack_id, circuit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE pack_activity (pack_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_82FB4D4B1919B217 (pack_id), INDEX IDX_82FB4D4B81C06096 (activity_id), PRIMARY KEY(pack_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE wishlist (id INT AUTO_INCREMENT NOT NULL, user_id CHAR(36) NOT NULL, INDEX IDX_9CE12A31A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE wishlist_activity (wishlist_id INT NOT NULL, activity_id INT NOT NULL, INDEX IDX_1C3B9DAEFB8E54CD (wishlist_id), INDEX IDX_1C3B9DAE81C06096 (activity_id), PRIMARY KEY(wishlist_id, activity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE activity_user ADD CONSTRAINT FK_8E570DDB81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_user ADD CONSTRAINT FK_8E570DDBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cart ADD CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cart_item ADD CONSTRAINT FK_F0FE25271AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id)');
        $this->addSql('ALTER TABLE circuit_activity ADD CONSTRAINT FK_7C29C2FBCF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE circuit_activity ADD CONSTRAINT FK_7C29C2FB81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE circuit_user ADD CONSTRAINT FK_E46BB0B4CF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE circuit_user ADD CONSTRAINT FK_E46BB0B4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CCF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE pack ADD CONSTRAINT FK_97DE5E23A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pack_circuit ADD CONSTRAINT FK_286C63DB1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_circuit ADD CONSTRAINT FK_286C63DBCF2182C8 FOREIGN KEY (circuit_id) REFERENCES circuit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_activity ADD CONSTRAINT FK_82FB4D4B1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_activity ADD CONSTRAINT FK_82FB4D4B81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wishlist_activity ADD CONSTRAINT FK_1C3B9DAEFB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist_activity ADD CONSTRAINT FK_1C3B9DAE81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity_user DROP FOREIGN KEY FK_8E570DDB81C06096');
        $this->addSql('ALTER TABLE activity_user DROP FOREIGN KEY FK_8E570DDBA76ED395');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE cart_item DROP FOREIGN KEY FK_F0FE25271AD5CDBF');
        $this->addSql('ALTER TABLE circuit_activity DROP FOREIGN KEY FK_7C29C2FBCF2182C8');
        $this->addSql('ALTER TABLE circuit_activity DROP FOREIGN KEY FK_7C29C2FB81C06096');
        $this->addSql('ALTER TABLE circuit_user DROP FOREIGN KEY FK_E46BB0B4CF2182C8');
        $this->addSql('ALTER TABLE circuit_user DROP FOREIGN KEY FK_E46BB0B4A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CCF2182C8');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C81C06096');
        $this->addSql('ALTER TABLE pack DROP FOREIGN KEY FK_97DE5E23A76ED395');
        $this->addSql('ALTER TABLE pack_circuit DROP FOREIGN KEY FK_286C63DB1919B217');
        $this->addSql('ALTER TABLE pack_circuit DROP FOREIGN KEY FK_286C63DBCF2182C8');
        $this->addSql('ALTER TABLE pack_activity DROP FOREIGN KEY FK_82FB4D4B1919B217');
        $this->addSql('ALTER TABLE pack_activity DROP FOREIGN KEY FK_82FB4D4B81C06096');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A31A76ED395');
        $this->addSql('ALTER TABLE wishlist_activity DROP FOREIGN KEY FK_1C3B9DAEFB8E54CD');
        $this->addSql('ALTER TABLE wishlist_activity DROP FOREIGN KEY FK_1C3B9DAE81C06096');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE activity_user');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE circuit');
        $this->addSql('DROP TABLE circuit_activity');
        $this->addSql('DROP TABLE circuit_user');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE pack_circuit');
        $this->addSql('DROP TABLE pack_activity');
        $this->addSql('DROP TABLE wishlist');
        $this->addSql('DROP TABLE wishlist_activity');
    }
}
