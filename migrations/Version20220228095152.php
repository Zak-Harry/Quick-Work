<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228095152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE effective_work_days CHANGE hoursworked hoursworked TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE planned_work_days CHANGE hoursplanned hoursplanned TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE effective_work_days CHANGE hoursworked hoursworked DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE planned_work_days CHANGE hoursplanned hoursplanned DATETIME NOT NULL');
    }
}
