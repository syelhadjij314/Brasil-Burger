<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625120112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boisson (id INT NOT NULL, taille VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE burger (id INT NOT NULL, menu_id INT DEFAULT NULL, INDEX IDX_EFE35A0DCCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, UNIQUE INDEX UNIQ_C7440455AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, numero_commande VARCHAR(255) NOT NULL, date_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE complement (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE complement_boisson (complement_id INT NOT NULL, boisson_id INT NOT NULL, INDEX IDX_3370DB4040D9D0AA (complement_id), INDEX IDX_3370DB40734B8089 (boisson_id), PRIMARY KEY(complement_id, boisson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE complement_frite (complement_id INT NOT NULL, frite_id INT NOT NULL, INDEX IDX_9336E89340D9D0AA (complement_id), INDEX IDX_9336E893BE00B4D9 (frite_id), PRIMARY KEY(complement_id, frite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frite (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gestionnaire (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F4461B20AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, matricule_moto VARCHAR(255) NOT NULL, telephone INT NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_complement (menu_id INT NOT NULL, complement_id INT NOT NULL, INDEX IDX_D909AAE6CCD7E912 (menu_id), INDEX IDX_D909AAE640D9D0AA (complement_id), PRIMARY KEY(menu_id, complement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, gestionnaire_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, is_etat TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_29A5EC276885AC1B (gestionnaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84DBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement_boisson ADD CONSTRAINT FK_3370DB4040D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement_boisson ADD CONSTRAINT FK_3370DB40734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement_frite ADD CONSTRAINT FK_9336E89340D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE complement_frite ADD CONSTRAINT FK_9336E893BE00B4D9 FOREIGN KEY (frite_id) REFERENCES frite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE frite ADD CONSTRAINT FK_20EBC46DBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93BF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_complement ADD CONSTRAINT FK_D909AAE6CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_complement ADD CONSTRAINT FK_D909AAE640D9D0AA FOREIGN KEY (complement_id) REFERENCES complement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE complement_boisson DROP FOREIGN KEY FK_3370DB40734B8089');
        $this->addSql('ALTER TABLE complement_boisson DROP FOREIGN KEY FK_3370DB4040D9D0AA');
        $this->addSql('ALTER TABLE complement_frite DROP FOREIGN KEY FK_9336E89340D9D0AA');
        $this->addSql('ALTER TABLE menu_complement DROP FOREIGN KEY FK_D909AAE640D9D0AA');
        $this->addSql('ALTER TABLE complement_frite DROP FOREIGN KEY FK_9336E893BE00B4D9');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276885AC1B');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DCCD7E912');
        $this->addSql('ALTER TABLE menu_complement DROP FOREIGN KEY FK_D909AAE6CCD7E912');
        $this->addSql('ALTER TABLE boisson DROP FOREIGN KEY FK_8B97C84DBF396750');
        $this->addSql('ALTER TABLE burger DROP FOREIGN KEY FK_EFE35A0DBF396750');
        $this->addSql('ALTER TABLE frite DROP FOREIGN KEY FK_20EBC46DBF396750');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93BF396750');
        $this->addSql('DROP TABLE boisson');
        $this->addSql('DROP TABLE burger');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE complement');
        $this->addSql('DROP TABLE complement_boisson');
        $this->addSql('DROP TABLE complement_frite');
        $this->addSql('DROP TABLE frite');
        $this->addSql('DROP TABLE gestionnaire');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_complement');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE user');
    }
}
