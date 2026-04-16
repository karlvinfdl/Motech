<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260414220828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id_avis INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, jeu_prefere VARCHAR(50) DEFAULT NULL, date_creation DATETIME NOT NULL, id_utilisateur INT NOT NULL, INDEX IDX_8F91ABF050EAE44 (id_utilisateur), PRIMARY KEY (id_avis)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE professionnel (siret VARCHAR(17) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, classification VARCHAR(50) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, id_utilisateur INT NOT NULL, UNIQUE INDEX UNIQ_7A28C10F26E94372 (siret), PRIMARY KEY (id_utilisateur)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE professionnel_service (id_utilisateur INT NOT NULL, id_service INT NOT NULL, INDEX IDX_7E02820950EAE44 (id_utilisateur), INDEX IDX_7E0282093F0033A2 (id_service), PRIMARY KEY (id_utilisateur, id_service)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (id_service INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, PRIMARY KEY (id_service)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id_utilisateur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(60) NOT NULL, date_naissance DATE DEFAULT NULL, email VARCHAR(100) NOT NULL, ville VARCHAR(50) DEFAULT NULL, genre VARCHAR(30) DEFAULT NULL, date_inscription DATETIME NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY (id_utilisateur)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF050EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE professionnel ADD CONSTRAINT FK_7A28C10F50EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateur (id_utilisateur)');
        $this->addSql('ALTER TABLE professionnel_service ADD CONSTRAINT FK_7E02820950EAE44 FOREIGN KEY (id_utilisateur) REFERENCES professionnel (id_utilisateur)');
        $this->addSql('ALTER TABLE professionnel_service ADD CONSTRAINT FK_7E0282093F0033A2 FOREIGN KEY (id_service) REFERENCES service (id_service)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF050EAE44');
        $this->addSql('ALTER TABLE professionnel DROP FOREIGN KEY FK_7A28C10F50EAE44');
        $this->addSql('ALTER TABLE professionnel_service DROP FOREIGN KEY FK_7E02820950EAE44');
        $this->addSql('ALTER TABLE professionnel_service DROP FOREIGN KEY FK_7E0282093F0033A2');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE professionnel');
        $this->addSql('DROP TABLE professionnel_service');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE utilisateur');
    }
}
