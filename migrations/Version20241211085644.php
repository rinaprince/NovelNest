<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211085644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client CHANGE pseudonim pseudonim VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74404557C96A3C1 ON client (pseudonim)');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA00919EB6921');
        $this->addSql('ALTER TABLE factura ADD preu NUMERIC(10, 2) NOT NULL, ADD quantitat INT NOT NULL');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA00919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE rols rols JSON NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE rols rols LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('DROP INDEX UNIQ_C74404557C96A3C1 ON client');
        $this->addSql('ALTER TABLE client CHANGE pseudonim pseudonim VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA00919EB6921');
        $this->addSql('ALTER TABLE factura DROP preu, DROP quantitat');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA00919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }
}
