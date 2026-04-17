<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260417082935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id_avis INT AUTO_INCREMENT NOT NULL, message VARCHAR(300) DEFAULT NULL, jeu_prefere VARCHAR(50) DEFAULT NULL, date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, note INT DEFAULT NULL, id_utilisateur INT NOT NULL, INDEX IDX_8F91ABF050EAE44 (id_utilisateur), PRIMARY KEY (id_avis)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE service (id_service INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(150) NOT NULL, demande_special VARCHAR(300) DEFAULT NULL, PRIMARY KEY (id_service)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateurs (id_utilisateur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(60) NOT NULL, date_naissance DATETIME DEFAULT NULL, email VARCHAR(100) NOT NULL, ville VARCHAR(50) DEFAULT NULL, siret VARCHAR(17) DEFAULT NULL, nom_domaine VARCHAR(255) DEFAULT NULL, date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_497B315EE7927C74 (email), UNIQUE INDEX UNIQ_497B315E26E94372 (siret), PRIMARY KEY (id_utilisateur)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateurs_service (id_utilisateur_service INT AUTO_INCREMENT NOT NULL, id_utilisateurs INT NOT NULL, id_service INT NOT NULL, INDEX IDX_EF6BF3876ABA442C (id_utilisateurs), INDEX IDX_EF6BF3873F0033A2 (id_service), PRIMARY KEY (id_utilisateur_service)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF050EAE44 FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs (id_utilisateur)');
        $this->addSql('ALTER TABLE utilisateurs_service ADD CONSTRAINT FK_EF6BF3876ABA442C FOREIGN KEY (id_utilisateurs) REFERENCES utilisateurs (id_utilisateur)');
        $this->addSql('ALTER TABLE utilisateurs_service ADD CONSTRAINT FK_EF6BF3873F0033A2 FOREIGN KEY (id_service) REFERENCES service (id_service)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF050EAE44');
        $this->addSql('ALTER TABLE utilisateurs_service DROP FOREIGN KEY FK_EF6BF3876ABA442C');
        $this->addSql('ALTER TABLE utilisateurs_service DROP FOREIGN KEY FK_EF6BF3873F0033A2');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE utilisateurs_service');
    }
}
