<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301085602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_planned_work_days (user_id INT NOT NULL, planned_work_days_id INT NOT NULL, INDEX IDX_6F7C3271A76ED395 (user_id), INDEX IDX_6F7C327139907D21 (planned_work_days_id), PRIMARY KEY(user_id, planned_work_days_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_planned_work_days ADD CONSTRAINT FK_6F7C3271A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_planned_work_days ADD CONSTRAINT FK_6F7C327139907D21 FOREIGN KEY (planned_work_days_id) REFERENCES planned_work_days (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_planned_work_days');
    }
}
