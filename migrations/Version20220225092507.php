<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220225092507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement_job DROP FOREIGN KEY FK_6ACF4CE87E182327');
        $this->addSql('ALTER TABLE departement_job DROP FOREIGN KEY FK_6ACF4CE8EAE6F2D2');
        $this->addSql('DROP INDEX IDX_6ACF4CE8EAE6F2D2 ON departement_job');
        $this->addSql('DROP INDEX IDX_6ACF4CE87E182327 ON departement_job');
        $this->addSql('ALTER TABLE departement_job CHANGE job_id_id job_id INT NOT NULL, CHANGE departement_id_id departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departement_job ADD CONSTRAINT FK_6ACF4CE8BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE departement_job ADD CONSTRAINT FK_6ACF4CE8CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_6ACF4CE8BE04EA9 ON departement_job (job_id)');
        $this->addSql('CREATE INDEX IDX_6ACF4CE8CCF9E01E ON departement_job (departement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement_job DROP FOREIGN KEY FK_6ACF4CE8BE04EA9');
        $this->addSql('ALTER TABLE departement_job DROP FOREIGN KEY FK_6ACF4CE8CCF9E01E');
        $this->addSql('DROP INDEX IDX_6ACF4CE8BE04EA9 ON departement_job');
        $this->addSql('DROP INDEX IDX_6ACF4CE8CCF9E01E ON departement_job');
        $this->addSql('ALTER TABLE departement_job CHANGE job_id job_id_id INT NOT NULL, CHANGE departement_id departement_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE departement_job ADD CONSTRAINT FK_6ACF4CE87E182327 FOREIGN KEY (job_id_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE departement_job ADD CONSTRAINT FK_6ACF4CE8EAE6F2D2 FOREIGN KEY (departement_id_id) REFERENCES departement (id)');
        $this->addSql('CREATE INDEX IDX_6ACF4CE8EAE6F2D2 ON departement_job (departement_id_id)');
        $this->addSql('CREATE INDEX IDX_6ACF4CE87E182327 ON departement_job (job_id_id)');
    }
}
