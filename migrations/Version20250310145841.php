<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250310145841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devis_design (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, devis_id INT DEFAULT NULL, design VARCHAR(255) NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_F15A9DFC4584665A (product_id), INDEX IDX_F15A9DFC41DEFADA (devis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devis_design ADD CONSTRAINT FK_F15A9DFC4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE devis_design ADD CONSTRAINT FK_F15A9DFC41DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id)');
        $this->addSql('ALTER TABLE devis_product DROP FOREIGN KEY FK_41A49FF141DEFADA');
        $this->addSql('ALTER TABLE devis_product DROP FOREIGN KEY FK_41A49FF14584665A');
        $this->addSql('DROP TABLE devis_product');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devis_product (devis_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_41A49FF141DEFADA (devis_id), INDEX IDX_41A49FF14584665A (product_id), PRIMARY KEY(devis_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE devis_product ADD CONSTRAINT FK_41A49FF141DEFADA FOREIGN KEY (devis_id) REFERENCES devis (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_product ADD CONSTRAINT FK_41A49FF14584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE devis_design DROP FOREIGN KEY FK_F15A9DFC4584665A');
        $this->addSql('ALTER TABLE devis_design DROP FOREIGN KEY FK_F15A9DFC41DEFADA');
        $this->addSql('DROP TABLE devis_design');
    }
}
