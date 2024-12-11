<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210171734 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045555C5F988');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045555C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045555C5F988');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045555C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
    }
}
