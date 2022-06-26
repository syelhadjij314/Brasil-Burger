<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626155256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, DROP plain_password');
        $this->addSql('ALTER TABLE gestionnaire ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, DROP plain_password');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, DROP plain_password');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD plain_password VARCHAR(255) DEFAULT NULL, DROP nom, DROP prenom');
        $this->addSql('ALTER TABLE gestionnaire ADD plain_password VARCHAR(255) DEFAULT NULL, DROP nom, DROP prenom');
        $this->addSql('ALTER TABLE user ADD plain_password VARCHAR(255) DEFAULT NULL, DROP nom, DROP prenom');
    }
}
