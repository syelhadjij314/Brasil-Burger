<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806113006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_boisson_taille (id INT AUTO_INCREMENT NOT NULL, boisson_taille_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, INDEX IDX_CB21213B75B6EEA7 (boisson_taille_id), INDEX IDX_CB21213B82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_boisson_taille ADD CONSTRAINT FK_CB21213B75B6EEA7 FOREIGN KEY (boisson_taille_id) REFERENCES boisson_taille (id)');
        $this->addSql('ALTER TABLE commande_boisson_taille ADD CONSTRAINT FK_CB21213B82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('DROP TABLE menu_boisson');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_boisson (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, boisson_id INT DEFAULT NULL, quantite_boisson INT NOT NULL, INDEX IDX_34CD5F3734B8089 (boisson_id), INDEX IDX_34CD5F3CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE commande_boisson_taille');
    }
}
