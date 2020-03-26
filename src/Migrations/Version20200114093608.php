<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200114093608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affectation DROP id_rub, DROP id_org');
        $this->addSql('ALTER TABLE fiche DROP rubriques');
        $this->addSql('ALTER TABLE fiche ADD CONSTRAINT FK_4C13CC783BD38833 FOREIGN KEY (rubrique_id) REFERENCES fiche (id)');
        $this->addSql('CREATE INDEX IDX_4C13CC783BD38833 ON fiche (rubrique_id)');
        $this->addSql('ALTER TABLE organisme DROP FOREIGN KEY FK_DD0F4533A59E558C');
        $this->addSql('DROP INDEX IDX_DD0F4533A59E558C ON organisme');
        $this->addSql('ALTER TABLE organisme ADD rubrique_id INT NOT NULL, ADD affectation_id INT NOT NULL, DROP _id_rub_id, DROP id_referent');
        $this->addSql('ALTER TABLE organisme ADD CONSTRAINT FK_DD0F45333BD38833 FOREIGN KEY (rubrique_id) REFERENCES organisme (id)');
        $this->addSql('ALTER TABLE organisme ADD CONSTRAINT FK_DD0F45336D0ABA22 FOREIGN KEY (affectation_id) REFERENCES organisme (id)');
        $this->addSql('CREATE INDEX IDX_DD0F45333BD38833 ON organisme (rubrique_id)');
        $this->addSql('CREATE INDEX IDX_DD0F45336D0ABA22 ON organisme (affectation_id)');
        $this->addSql('ALTER TABLE referent ADD organisme_id INT NOT NULL, ADD fiche_id INT NOT NULL, DROP referent');
        $this->addSql('ALTER TABLE referent ADD CONSTRAINT FK_FE9AAC6C5DDD38F5 FOREIGN KEY (organisme_id) REFERENCES referent (id)');
        $this->addSql('ALTER TABLE referent ADD CONSTRAINT FK_FE9AAC6CDF522508 FOREIGN KEY (fiche_id) REFERENCES referent (id)');
        $this->addSql('CREATE INDEX IDX_FE9AAC6C5DDD38F5 ON referent (organisme_id)');
        $this->addSql('CREATE INDEX IDX_FE9AAC6CDF522508 ON referent (fiche_id)');
        $this->addSql('ALTER TABLE ruborg DROP FOREIGN KEY FK_DA613ECCE802F491');
        $this->addSql('DROP INDEX IDX_DA613ECCE802F491 ON ruborg');
        $this->addSql('ALTER TABLE ruborg DROP id_rub_id');
        $this->addSql('ALTER TABLE rubrique ADD organisme_id INT NOT NULL, ADD affectation_id INT NOT NULL, DROP id_fiche, DROP _id_org');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097C5DDD38F5 FOREIGN KEY (organisme_id) REFERENCES rubrique (id)');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097C6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_8FA4097C5DDD38F5 ON rubrique (organisme_id)');
        $this->addSql('CREATE INDEX IDX_8FA4097C6D0ABA22 ON rubrique (affectation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affectation ADD id_rub INT NOT NULL, ADD id_org INT NOT NULL');
        $this->addSql('ALTER TABLE fiche DROP FOREIGN KEY FK_4C13CC783BD38833');
        $this->addSql('DROP INDEX IDX_4C13CC783BD38833 ON fiche');
        $this->addSql('ALTER TABLE fiche ADD rubriques VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE organisme DROP FOREIGN KEY FK_DD0F45333BD38833');
        $this->addSql('ALTER TABLE organisme DROP FOREIGN KEY FK_DD0F45336D0ABA22');
        $this->addSql('DROP INDEX IDX_DD0F45333BD38833 ON organisme');
        $this->addSql('DROP INDEX IDX_DD0F45336D0ABA22 ON organisme');
        $this->addSql('ALTER TABLE organisme ADD _id_rub_id INT DEFAULT NULL, ADD id_referent INT DEFAULT NULL, DROP rubrique_id, DROP affectation_id');
        $this->addSql('ALTER TABLE organisme ADD CONSTRAINT FK_DD0F4533A59E558C FOREIGN KEY (_id_rub_id) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_DD0F4533A59E558C ON organisme (_id_rub_id)');
        $this->addSql('ALTER TABLE referent DROP FOREIGN KEY FK_FE9AAC6C5DDD38F5');
        $this->addSql('ALTER TABLE referent DROP FOREIGN KEY FK_FE9AAC6CDF522508');
        $this->addSql('DROP INDEX IDX_FE9AAC6C5DDD38F5 ON referent');
        $this->addSql('DROP INDEX IDX_FE9AAC6CDF522508 ON referent');
        $this->addSql('ALTER TABLE referent ADD referent VARCHAR(3) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP organisme_id, DROP fiche_id');
        $this->addSql('ALTER TABLE ruborg ADD id_rub_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ruborg ADD CONSTRAINT FK_DA613ECCE802F491 FOREIGN KEY (id_rub_id) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_DA613ECCE802F491 ON ruborg (id_rub_id)');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097C5DDD38F5');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097C6D0ABA22');
        $this->addSql('DROP INDEX IDX_8FA4097C5DDD38F5 ON rubrique');
        $this->addSql('DROP INDEX IDX_8FA4097C6D0ABA22 ON rubrique');
        $this->addSql('ALTER TABLE rubrique ADD id_fiche INT DEFAULT NULL, ADD _id_org INT DEFAULT NULL, DROP organisme_id, DROP affectation_id');
    }
}
