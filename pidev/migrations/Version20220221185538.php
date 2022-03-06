<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221185538 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A6816575');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A6816575 FOREIGN KEY (id_User) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB38857CCB');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBA6816575');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB38857CCB FOREIGN KEY (id_Produit) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA6816575 FOREIGN KEY (id_User) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC274BB9E8B0');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274BB9E8B0 FOREIGN KEY (id_Categorie) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE randonnee DROP FOREIGN KEY FK_CB71A99FFBC77456');
        $this->addSql('ALTER TABLE randonnee ADD CONSTRAINT FK_CB71A99FFBC77456 FOREIGN KEY (id_activ) REFERENCES activitie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_ron DROP FOREIGN KEY FK_B55973C44B4415B8');
        $this->addSql('ALTER TABLE reservation_ron DROP FOREIGN KEY FK_B55973C4A6816575');
        $this->addSql('ALTER TABLE reservation_ron ADD CONSTRAINT FK_B55973C44B4415B8 FOREIGN KEY (id_randonnee) REFERENCES randonnee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_ron ADD CONSTRAINT FK_B55973C4A6816575 FOREIGN KEY (id_User) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activitie CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A6816575');
        $this->addSql('ALTER TABLE article CHANGE titre titre VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A6816575 FOREIGN KEY (id_User) REFERENCES users (id)');
        $this->addSql('ALTER TABLE avis CHANGE rate rate VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE categorie CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commentaire CHANGE commentaire commentaire VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE event CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE location location VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CBA6816575');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB38857CCB');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CBA6816575 FOREIGN KEY (id_User) REFERENCES users (id)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB38857CCB FOREIGN KEY (id_Produit) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC274BB9E8B0');
        $this->addSql('ALTER TABLE produit CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC274BB9E8B0 FOREIGN KEY (id_Categorie) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE promotion CHANGE theme theme VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE randonnee DROP FOREIGN KEY FK_CB71A99FFBC77456');
        $this->addSql('ALTER TABLE randonnee CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE localisation localisation VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE randonnee ADD CONSTRAINT FK_CB71A99FFBC77456 FOREIGN KEY (id_activ) REFERENCES activitie (id)');
        $this->addSql('ALTER TABLE reclamation CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE objet objet VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reservation_ron DROP FOREIGN KEY FK_B55973C4A6816575');
        $this->addSql('ALTER TABLE reservation_ron DROP FOREIGN KEY FK_B55973C44B4415B8');
        $this->addSql('ALTER TABLE reservation_ron ADD CONSTRAINT FK_B55973C4A6816575 FOREIGN KEY (id_User) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservation_ron ADD CONSTRAINT FK_B55973C44B4415B8 FOREIGN KEY (id_randonnee) REFERENCES randonnee (id)');
        $this->addSql('ALTER TABLE sponsor CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contrat contrat VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image image VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
