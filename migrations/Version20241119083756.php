<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241119083756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrador (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE arxiu (id INT AUTO_INCREMENT NOT NULL, arxiu_pdf VARCHAR(255) NOT NULL, arxiu_portada VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, id_factura_id INT NOT NULL, telef VARCHAR(50) NOT NULL, direccio VARCHAR(255) NOT NULL, num_tarj VARCHAR(255) NOT NULL, INDEX IDX_C744045555C5F988 (id_factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE factura (id INT AUTO_INCREMENT NOT NULL, num_factura_seg_id INT NOT NULL, preu VARCHAR(255) NOT NULL, data DATE NOT NULL, UNIQUE INDEX UNIQ_F9EBA009B1CC4FE9 (num_factura_seg_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE obra (id INT AUTO_INCREMENT NOT NULL, pseudonim_client_id INT NOT NULL, url_arxiu_id INT NOT NULL, tipus VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, num_obra_seguiment INT NOT NULL, estat TINYINT(1) NOT NULL, portada VARCHAR(255) NOT NULL, INDEX IDX_2EEE6DBDDC0414A3 (pseudonim_client_id), INDEX IDX_2EEE6DBDD64606DB (url_arxiu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treballador (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom_usuari VARCHAR(50) NOT NULL, contrasenya VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, cognom VARCHAR(50) NOT NULL, correu VARCHAR(50) NOT NULL, rols LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', rol VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrador ADD CONSTRAINT FK_44F9A521BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045555C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009B1CC4FE9 FOREIGN KEY (num_factura_seg_id) REFERENCES obra (id)');
        $this->addSql('ALTER TABLE obra ADD CONSTRAINT FK_2EEE6DBDDC0414A3 FOREIGN KEY (pseudonim_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE obra ADD CONSTRAINT FK_2EEE6DBDD64606DB FOREIGN KEY (url_arxiu_id) REFERENCES arxiu (id)');
        $this->addSql('ALTER TABLE treballador ADD CONSTRAINT FK_CDE520CBBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrador DROP FOREIGN KEY FK_44F9A521BF396750');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045555C5F988');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455BF396750');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA009B1CC4FE9');
        $this->addSql('ALTER TABLE obra DROP FOREIGN KEY FK_2EEE6DBDDC0414A3');
        $this->addSql('ALTER TABLE obra DROP FOREIGN KEY FK_2EEE6DBDD64606DB');
        $this->addSql('ALTER TABLE treballador DROP FOREIGN KEY FK_CDE520CBBF396750');
        $this->addSql('DROP TABLE administrador');
        $this->addSql('DROP TABLE arxiu');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE factura');
        $this->addSql('DROP TABLE obra');
        $this->addSql('DROP TABLE treballador');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
