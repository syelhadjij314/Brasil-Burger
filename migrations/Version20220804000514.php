<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220804000514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taille ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taille ADD CONSTRAINT FK_76508B386885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_76508B386885AC1B ON taille (gestionnaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taille DROP FOREIGN KEY FK_76508B386885AC1B');
        $this->addSql('DROP INDEX IDX_76508B386885AC1B ON taille');
        $this->addSql('ALTER TABLE taille DROP gestionnaire_id');
    }
}
