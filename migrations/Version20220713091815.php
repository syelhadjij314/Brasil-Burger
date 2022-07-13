<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220713091815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE commande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE livraison_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE livreur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE menu_boisson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE menu_burger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE menu_frite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_commande_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quartier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE zone_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE boisson (id INT NOT NULL, taille VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE burger (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE commande (id INT NOT NULL, gestionnaire_id INT DEFAULT NULL, client_id INT DEFAULT NULL, zone_id INT DEFAULT NULL, livraison_id INT DEFAULT NULL, numero_commande VARCHAR(255) NOT NULL, date_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6EEAA67D6885AC1B ON commande (gestionnaire_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D9F2C3FAB ON commande (zone_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D8E54FB25 ON commande (livraison_id)');
        $this->addSql('CREATE TABLE frite (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE gestionnaire (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE livraison (id INT NOT NULL, livreur_id INT DEFAULT NULL, montant_tolal DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A60C9F1FF8646701 ON livraison (livreur_id)');
        $this->addSql('CREATE TABLE livreur (id INT NOT NULL, matricule_moto VARCHAR(255) NOT NULL, telephone INT NOT NULL, etat VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE menu (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE menu_boisson (id INT NOT NULL, menu_id INT DEFAULT NULL, boisson_id INT DEFAULT NULL, quantite_boisson INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_34CD5F3CCD7E912 ON menu_boisson (menu_id)');
        $this->addSql('CREATE INDEX IDX_34CD5F3734B8089 ON menu_boisson (boisson_id)');
        $this->addSql('CREATE TABLE menu_burger (id INT NOT NULL, menu_id INT DEFAULT NULL, burger_id INT DEFAULT NULL, quantite_burger INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3CA402D5CCD7E912 ON menu_burger (menu_id)');
        $this->addSql('CREATE INDEX IDX_3CA402D517CE5090 ON menu_burger (burger_id)');
        $this->addSql('CREATE TABLE menu_frite (id INT NOT NULL, menu_id INT DEFAULT NULL, frite_id INT DEFAULT NULL, quantite_frite INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B147E70ACCD7E912 ON menu_frite (menu_id)');
        $this->addSql('CREATE INDEX IDX_B147E70ABE00B4D9 ON menu_frite (frite_id)');
        $this->addSql('CREATE TABLE produit (id INT NOT NULL, gestionnaire_id INT DEFAULT NULL, prix INT NOT NULL, is_etat BOOLEAN NOT NULL, nom VARCHAR(255) NOT NULL, image BYTEA DEFAULT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_29A5EC276885AC1B ON produit (gestionnaire_id)');
        $this->addSql('CREATE TABLE produit_commande (id INT NOT NULL, produit_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, prix DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_47F5946EF347EFB ON produit_commande (produit_id)');
        $this->addSql('CREATE INDEX IDX_47F5946E82EA2E54 ON produit_commande (commande_id)');
        $this->addSql('CREATE TABLE quartier (id INT NOT NULL, zone_id INT DEFAULT NULL, gestionnaire_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FEE8962DA4D60759 ON quartier (libelle)');
        $this->addSql('CREATE INDEX IDX_FEE8962D9F2C3FAB ON quartier (zone_id)');
        $this->addSql('CREATE INDEX IDX_FEE8962D6885AC1B ON quartier (gestionnaire_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) DEFAULT NULL, is_enable BOOLEAN DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, expire_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON "user" (login)');
        $this->addSql('CREATE TABLE zone (id INT NOT NULL, gestionnaire_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A0EBC0076C6E55B5 ON zone (nom)');
        $this->addSql('CREATE INDEX IDX_A0EBC0076885AC1B ON zone (gestionnaire_id)');
        $this->addSql('ALTER TABLE boisson ADD CONSTRAINT FK_8B97C84DBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE burger ADD CONSTRAINT FK_EFE35A0DBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455BF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE frite ADD CONSTRAINT FK_20EBC46DBF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gestionnaire ADD CONSTRAINT FK_F4461B20BF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE livraison ADD CONSTRAINT FK_A60C9F1FF8646701 FOREIGN KEY (livreur_id) REFERENCES livreur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93BF396750 FOREIGN KEY (id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_boisson ADD CONSTRAINT FK_34CD5F3734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D5CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_burger ADD CONSTRAINT FK_3CA402D517CE5090 FOREIGN KEY (burger_id) REFERENCES burger (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ACCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE menu_frite ADD CONSTRAINT FK_B147E70ABE00B4D9 FOREIGN KEY (frite_id) REFERENCES frite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946EF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_commande ADD CONSTRAINT FK_47F5946E82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D9F2C3FAB FOREIGN KEY (zone_id) REFERENCES zone (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE zone ADD CONSTRAINT FK_A0EBC0076885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE menu_boisson DROP CONSTRAINT FK_34CD5F3734B8089');
        $this->addSql('ALTER TABLE menu_burger DROP CONSTRAINT FK_3CA402D517CE5090');
        $this->addSql('ALTER TABLE produit_commande DROP CONSTRAINT FK_47F5946E82EA2E54');
        $this->addSql('ALTER TABLE menu_frite DROP CONSTRAINT FK_B147E70ABE00B4D9');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D8E54FB25');
        $this->addSql('ALTER TABLE livraison DROP CONSTRAINT FK_A60C9F1FF8646701');
        $this->addSql('ALTER TABLE menu_boisson DROP CONSTRAINT FK_34CD5F3CCD7E912');
        $this->addSql('ALTER TABLE menu_burger DROP CONSTRAINT FK_3CA402D5CCD7E912');
        $this->addSql('ALTER TABLE menu_frite DROP CONSTRAINT FK_B147E70ACCD7E912');
        $this->addSql('ALTER TABLE boisson DROP CONSTRAINT FK_8B97C84DBF396750');
        $this->addSql('ALTER TABLE burger DROP CONSTRAINT FK_EFE35A0DBF396750');
        $this->addSql('ALTER TABLE frite DROP CONSTRAINT FK_20EBC46DBF396750');
        $this->addSql('ALTER TABLE menu DROP CONSTRAINT FK_7D053A93BF396750');
        $this->addSql('ALTER TABLE produit_commande DROP CONSTRAINT FK_47F5946EF347EFB');
        $this->addSql('ALTER TABLE client DROP CONSTRAINT FK_C7440455BF396750');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D6885AC1B');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE gestionnaire DROP CONSTRAINT FK_F4461B20BF396750');
        $this->addSql('ALTER TABLE produit DROP CONSTRAINT FK_29A5EC276885AC1B');
        $this->addSql('ALTER TABLE quartier DROP CONSTRAINT FK_FEE8962D6885AC1B');
        $this->addSql('ALTER TABLE zone DROP CONSTRAINT FK_A0EBC0076885AC1B');
        $this->addSql('ALTER TABLE commande DROP CONSTRAINT FK_6EEAA67D9F2C3FAB');
        $this->addSql('ALTER TABLE quartier DROP CONSTRAINT FK_FEE8962D9F2C3FAB');
        $this->addSql('DROP SEQUENCE commande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE livraison_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE livreur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE menu_boisson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE menu_burger_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE menu_frite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_commande_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quartier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE zone_id_seq CASCADE');
        $this->addSql('DROP TABLE boisson');
        $this->addSql('DROP TABLE burger');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE frite');
        $this->addSql('DROP TABLE gestionnaire');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE livreur');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_boisson');
        $this->addSql('DROP TABLE menu_burger');
        $this->addSql('DROP TABLE menu_frite');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_commande');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE zone');
    }
}
