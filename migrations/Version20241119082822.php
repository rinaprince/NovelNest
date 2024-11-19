<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119082822 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arxiu ADD arxiu_portada VARCHAR(255) NOT NULL, DROP id_obra, CHANGE url_arxiu arxiu_pdf VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client DROP pseudonim');
        $this->addSql('ALTER TABLE factura CHANGE num_factura num_factura_seg_id INT NOT NULL');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009B1CC4FE9 FOREIGN KEY (num_factura_seg_id) REFERENCES obra (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F9EBA009B1CC4FE9 ON factura (num_factura_seg_id)');
        $this->addSql('ALTER TABLE obra ADD url_arxiu_id INT NOT NULL, ADD portada VARCHAR(255) NOT NULL, DROP pseudonim_client, CHANGE id_factura pseudonim_client_id INT NOT NULL');
        $this->addSql('ALTER TABLE obra ADD CONSTRAINT FK_2EEE6DBDDC0414A3 FOREIGN KEY (pseudonim_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE obra ADD CONSTRAINT FK_2EEE6DBDD64606DB FOREIGN KEY (url_arxiu_id) REFERENCES arxiu (id)');
        $this->addSql('CREATE INDEX IDX_2EEE6DBDDC0414A3 ON obra (pseudonim_client_id)');
        $this->addSql('CREATE INDEX IDX_2EEE6DBDD64606DB ON obra (url_arxiu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obra DROP FOREIGN KEY FK_2EEE6DBDDC0414A3');
        $this->addSql('ALTER TABLE obra DROP FOREIGN KEY FK_2EEE6DBDD64606DB');
        $this->addSql('DROP INDEX IDX_2EEE6DBDDC0414A3 ON obra');
        $this->addSql('DROP INDEX IDX_2EEE6DBDD64606DB ON obra');
        $this->addSql('ALTER TABLE obra ADD pseudonim_client VARCHAR(50) NOT NULL, ADD id_factura INT NOT NULL, DROP pseudonim_client_id, DROP url_arxiu_id, DROP portada');
        $this->addSql('ALTER TABLE arxiu ADD url_arxiu VARCHAR(255) NOT NULL, ADD id_obra INT NOT NULL, DROP arxiu_pdf, DROP arxiu_portada');
        $this->addSql('ALTER TABLE client ADD pseudonim VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA009B1CC4FE9');
        $this->addSql('DROP INDEX UNIQ_F9EBA009B1CC4FE9 ON factura');
        $this->addSql('ALTER TABLE factura CHANGE num_factura_seg_id num_factura INT NOT NULL');
    }
}
