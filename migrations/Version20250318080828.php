<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318080828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_techno (id INT AUTO_INCREMENT NOT NULL, reso VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD techno_id INT DEFAULT NULL, ADD taille INT NOT NULL, ADD marque VARCHAR(255) NOT NULL, ADD reso INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD51F3C1BC FOREIGN KEY (techno_id) REFERENCES product_techno (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD51F3C1BC ON product (techno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD51F3C1BC');
        $this->addSql('DROP TABLE product_techno');
        $this->addSql('DROP INDEX IDX_D34A04AD51F3C1BC ON product');
        $this->addSql('ALTER TABLE product DROP techno_id, DROP taille, DROP marque, DROP reso');
    }
}
