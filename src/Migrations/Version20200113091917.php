<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200113091917 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, id_rub INT NOT NULL, id_org INT NOT NULL, modif_auto DATETIME NOT NULL, commentaire VARCHAR(240) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche (id INT AUTO_INCREMENT NOT NULL, modif_auto DATE DEFAULT NULL, titre VARCHAR(255) NOT NULL, chapeau VARCHAR(255) NOT NULL, rubriques VARCHAR(255) DEFAULT NULL, date_edition DATE NOT NULL, date_pub DATE NOT NULL, id_referent INT DEFAULT NULL, valid VARCHAR(10) NOT NULL, id_fiche INT DEFAULT NULL, id_rubweb INT DEFAULT NULL, voiraussi VARCHAR(255) NOT NULL, classement INT NOT NULL, theme VARCHAR(255) NOT NULL, numpage INT NOT NULL, numpagefin INT NOT NULL, partie VARCHAR(1) NOT NULL, etoile INT NOT NULL, theme_web VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisme (id INT AUTO_INCREMENT NOT NULL, crea_auto DATETIME NOT NULL, modif_auto DATE NOT NULL, nom_off VARCHAR(150) NOT NULL, nom_farm VARCHAR(50) NOT NULL, nom_siege VARCHAR(50) NOT NULL, mouvance VARCHAR(150) NOT NULL, rue VARCHAR(100) NOT NULL, cp VARCHAR(5) NOT NULL, ville VARCHAR(200) NOT NULL, cedex VARCHAR(20) NOT NULL, pays VARCHAR(50) NOT NULL, acces VARCHAR(250) NOT NULL, tel VARCHAR(10) NOT NULL, tel2 VARCHAR(10) NOT NULL, fax VARCHAR(10) NOT NULL, mail VARCHAR(100) DEFAULT NULL, web VARCHAR(100) NOT NULL, res_web VARCHAR(240) NOT NULL, res_det VARCHAR(255) NOT NULL, rem VARCHAR(255) NOT NULL, id_rubweb INT NOT NULL, id_edb VARCHAR(100) NOT NULL, valid_edb VARCHAR(20) NOT NULL, valid_web VARCHAR(100) NOT NULL, modif_date DATE NOT NULL, _id_rub INT NOT NULL, confidentiel VARCHAR(20) NOT NULL, id_referent INT NOT NULL, code_siege VARCHAR(5) NOT NULL, bonus LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE referent (id INT AUTO_INCREMENT NOT NULL, nom_off VARCHAR(150) NOT NULL, nom_farm VARCHAR(50) NOT NULL, contact VARCHAR(200) NOT NULL, tel VARCHAR(10) NOT NULL, mail VARCHAR(100) NOT NULL, admin VARCHAR(10) NOT NULL, referent VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ruborg (id INT AUTO_INCREMENT NOT NULL, id_rub INT NOT NULL, id_org INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubrique (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(200) NOT NULL, id_fiche INT NOT NULL, _id_org INT NOT NULL, classement INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE affectation');
        $this->addSql('DROP TABLE fiche');
        $this->addSql('DROP TABLE organisme');
        $this->addSql('DROP TABLE referent');
        $this->addSql('DROP TABLE ruborg');
        $this->addSql('DROP TABLE rubrique');
    }
}
