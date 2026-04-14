<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260414232513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
    }
}
