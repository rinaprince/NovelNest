<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241204134250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA009B1CC4FE9');
        $this->addSql('DROP INDEX UNIQ_F9EBA009B1CC4FE9 ON factura');
        $this->addSql('ALTER TABLE factura ADD client_id INT DEFAULT NULL, ADD num_factura VARCHAR(255) NOT NULL, DROP num_factura_seg_id, DROP data, CHANGE preu tipus VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA00919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_F9EBA00919EB6921 ON factura (client_id)');
        $this->addSql('ALTER TABLE obra ADD factura_id INT NOT NULL');
        $this->addSql('ALTER TABLE obra ADD CONSTRAINT FK_2EEE6DBDF04F795F FOREIGN KEY (factura_id) REFERENCES factura (id)');
        $this->addSql('CREATE INDEX IDX_2EEE6DBDF04F795F ON obra (factura_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obra DROP FOREIGN KEY FK_2EEE6DBDF04F795F');
        $this->addSql('DROP INDEX IDX_2EEE6DBDF04F795F ON obra');
        $this->addSql('ALTER TABLE obra DROP factura_id');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA00919EB6921');
        $this->addSql('DROP INDEX IDX_F9EBA00919EB6921 ON factura');
        $this->addSql('ALTER TABLE factura ADD num_factura_seg_id INT NOT NULL, ADD preu VARCHAR(255) NOT NULL, ADD data DATE NOT NULL, DROP client_id, DROP tipus, DROP num_factura');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009B1CC4FE9 FOREIGN KEY (num_factura_seg_id) REFERENCES obra (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F9EBA009B1CC4FE9 ON factura (num_factura_seg_id)');
    }
}
