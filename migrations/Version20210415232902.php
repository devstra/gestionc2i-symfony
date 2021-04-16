<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415232902 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE copie (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, salle_id INT NOT NULL, epreuve_id INT NOT NULL, note_finale DOUBLE PRECISION NOT NULL, mention_finale VARCHAR(3) NOT NULL, correcteur VARCHAR(255) NOT NULL, vague VARCHAR(255) NOT NULL, note_d1 DOUBLE PRECISION NOT NULL, note_d2 DOUBLE PRECISION NOT NULL, note_d3 DOUBLE PRECISION NOT NULL, note_tableur DOUBLE PRECISION NOT NULL, note_traitement_texte DOUBLE PRECISION NOT NULL, note_presentation_ao DOUBLE PRECISION NOT NULL, note_d4 DOUBLE PRECISION NOT NULL, note_d5 DOUBLE PRECISION NOT NULL, mention_d1 VARCHAR(3) NOT NULL, mention_d2 VARCHAR(3) NOT NULL, mention_d3 VARCHAR(3) NOT NULL, mention_d4 VARCHAR(3) NOT NULL, mention_d5 VARCHAR(3) NOT NULL, INDEX IDX_A6E330BCDDEAB1A3 (etudiant_id), INDEX IDX_A6E330BCDC304035 (salle_id), INDEX IDX_A6E330BCAB990336 (epreuve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE epreuve (id INT AUTO_INCREMENT NOT NULL, barre DOUBLE PRECISION NOT NULL, nom_ufr VARCHAR(255) NOT NULL, annee INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, groupe INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, capacite INT NOT NULL, lieu VARCHAR(255) NOT NULL, batiment VARCHAR(255) NOT NULL, etage VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BCDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BCDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE copie ADD CONSTRAINT FK_A6E330BCAB990336 FOREIGN KEY (epreuve_id) REFERENCES epreuve (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BCAB990336');
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BCDDEAB1A3');
        $this->addSql('ALTER TABLE copie DROP FOREIGN KEY FK_A6E330BCDC304035');
        $this->addSql('DROP TABLE copie');
        $this->addSql('DROP TABLE epreuve');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE salle');
    }
}
