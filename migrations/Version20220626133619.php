<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626133619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD plain_password VARCHAR(255) DEFAULT NULL, ADD token VARCHAR(255) DEFAULT NULL, ADD is_enable TINYINT(1) DEFAULT NULL, ADD expire_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE gestionnaire ADD plain_password VARCHAR(255) DEFAULT NULL, ADD token VARCHAR(255) DEFAULT NULL, ADD is_enable TINYINT(1) DEFAULT NULL, ADD expire_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE user ADD plain_password VARCHAR(255) DEFAULT NULL, ADD token VARCHAR(255) DEFAULT NULL, ADD is_enable TINYINT(1) DEFAULT NULL, ADD expire_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP plain_password, DROP token, DROP is_enable, DROP expire_at');
        $this->addSql('ALTER TABLE gestionnaire DROP plain_password, DROP token, DROP is_enable, DROP expire_at');
        $this->addSql('ALTER TABLE user DROP plain_password, DROP token, DROP is_enable, DROP expire_at');
    }
}
