<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241115074032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arxiu (id INT AUTO_INCREMENT NOT NULL, url_arxiu VARCHAR(255) NOT NULL, id_obra INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factura (id INT AUTO_INCREMENT NOT NULL, num_factura INT NOT NULL, preu VARCHAR(255) NOT NULL, data DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE obra (id INT AUTO_INCREMENT NOT NULL, tipus VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, pseudonim_client VARCHAR(50) NOT NULL, id_arxiu VARCHAR(50) NOT NULL, num_obra_seguiment INT NOT NULL, id_factura INT NOT NULL, estat TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD id_factura_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045555C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('CREATE INDEX IDX_C744045555C5F988 ON client (id_factura_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045555C5F988');
        $this->addSql('DROP TABLE arxiu');
        $this->addSql('DROP TABLE factura');
        $this->addSql('DROP TABLE obra');
        $this->addSql('DROP INDEX IDX_C744045555C5F988 ON client');
        $this->addSql('ALTER TABLE client DROP id_factura_id');
    }
}
