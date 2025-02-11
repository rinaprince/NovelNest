<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250211121527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obra DROP FOREIGN KEY FK_2EEE6DBDDC0414A3');
        $this->addSql('DROP INDEX IDX_2EEE6DBDDC0414A3 ON obra');
        $this->addSql('ALTER TABLE obra CHANGE num_obra_seguiment num_obra_seguiment INT NOT NULL, CHANGE pseudonim_client_id client_id INT NOT NULL');
        $this->addSql('ALTER TABLE obra ADD CONSTRAINT FK_2EEE6DBD19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_2EEE6DBD19EB6921 ON obra (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE obra DROP FOREIGN KEY FK_2EEE6DBD19EB6921');
        $this->addSql('DROP INDEX IDX_2EEE6DBD19EB6921 ON obra');
        $this->addSql('ALTER TABLE obra CHANGE num_obra_seguiment num_obra_seguiment INT DEFAULT NULL, CHANGE client_id pseudonim_client_id INT NOT NULL');
        $this->addSql('ALTER TABLE obra ADD CONSTRAINT FK_2EEE6DBDDC0414A3 FOREIGN KEY (pseudonim_client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_2EEE6DBDDC0414A3 ON obra (pseudonim_client_id)');
    }
}
