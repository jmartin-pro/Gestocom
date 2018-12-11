<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181209195940 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(100) NOT NULL, mdp VARCHAR(64) NOT NULL, archive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE container (id INT AUTO_INCREMENT NOT NULL, habitation_id INT NOT NULL, type_dechet_id INT NOT NULL, volume DOUBLE PRECISION NOT NULL, poids_brut DOUBLE PRECISION NOT NULL, charge_utile DOUBLE PRECISION NOT NULL, INDEX IDX_C7A2EC1B12708B4D (habitation_id), INDEX IDX_C7A2EC1BB93D2352 (type_dechet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitation (id INT AUTO_INCREMENT NOT NULL, usager_id INT NOT NULL, adresse VARCHAR(50) NOT NULL, copos VARCHAR(50) NOT NULL, ville VARCHAR(50) NOT NULL, archiver TINYINT(1) NOT NULL, INDEX IDX_3997FA9C4F36F0FC (usager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE levee (id INT AUTO_INCREMENT NOT NULL, container_id INT NOT NULL, date_levee DATETIME NOT NULL, poids DOUBLE PRECISION NOT NULL, INDEX IDX_E33674B7BC21F742 (container_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, usager_id INT NOT NULL, etat_id INT NOT NULL, objet VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, date_ouv DATETIME NOT NULL, date_ferm DATETIME NOT NULL, INDEX IDX_CE6064044F36F0FC (usager_id), INDEX IDX_CE606404D5E86FF (etat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, responsable_id INT NOT NULL, reclamation_id INT NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_5FB6DEC753C59D72 (responsable_id), INDEX IDX_5FB6DEC72D6BA2D9 (reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, compte_id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, date_naiss DATE NOT NULL, disc VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tarif (id INT AUTO_INCREMENT NOT NULL, type_dechet_id INT NOT NULL, date DATETIME NOT NULL, tarif DOUBLE PRECISION NOT NULL, INDEX IDX_E7189C9B93D2352 (type_dechet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_dechet (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usager (id INT NOT NULL, adresse VARCHAR(100) NOT NULL, copos VARCHAR(10) NOT NULL, ville VARCHAR(50) NOT NULL, mail VARCHAR(50) NOT NULL, tel VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE container ADD CONSTRAINT FK_C7A2EC1B12708B4D FOREIGN KEY (habitation_id) REFERENCES habitation (id)');
        $this->addSql('ALTER TABLE container ADD CONSTRAINT FK_C7A2EC1BB93D2352 FOREIGN KEY (type_dechet_id) REFERENCES type_dechet (id)');
        $this->addSql('ALTER TABLE habitation ADD CONSTRAINT FK_3997FA9C4F36F0FC FOREIGN KEY (usager_id) REFERENCES usager (id)');
        $this->addSql('ALTER TABLE levee ADD CONSTRAINT FK_E33674B7BC21F742 FOREIGN KEY (container_id) REFERENCES container (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064044F36F0FC FOREIGN KEY (usager_id) REFERENCES usager (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC753C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE responsable ADD CONSTRAINT FK_52520D07BF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tarif ADD CONSTRAINT FK_E7189C9B93D2352 FOREIGN KEY (type_dechet_id) REFERENCES type_dechet (id)');
        $this->addSql('ALTER TABLE usager ADD CONSTRAINT FK_3CDC65FFBF396750 FOREIGN KEY (id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3F2C56620');
        $this->addSql('ALTER TABLE levee DROP FOREIGN KEY FK_E33674B7BC21F742');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404D5E86FF');
        $this->addSql('ALTER TABLE container DROP FOREIGN KEY FK_C7A2EC1B12708B4D');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9');
        $this->addSql('ALTER TABLE responsable DROP FOREIGN KEY FK_52520D07BF396750');
        $this->addSql('ALTER TABLE usager DROP FOREIGN KEY FK_3CDC65FFBF396750');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC753C59D72');
        $this->addSql('ALTER TABLE container DROP FOREIGN KEY FK_C7A2EC1BB93D2352');
        $this->addSql('ALTER TABLE tarif DROP FOREIGN KEY FK_E7189C9B93D2352');
        $this->addSql('ALTER TABLE habitation DROP FOREIGN KEY FK_3997FA9C4F36F0FC');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064044F36F0FC');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE container');
        $this->addSql('DROP TABLE etat');
        $this->addSql('DROP TABLE habitation');
        $this->addSql('DROP TABLE levee');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE tarif');
        $this->addSql('DROP TABLE type_dechet');
        $this->addSql('DROP TABLE usager');
    }
}
