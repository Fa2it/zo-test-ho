<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190506101009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE car CHANGE image image VARCHAR(25) DEFAULT NULL');
        $this->addSql('ALTER TABLE act_code CHANGE user_id user_id INT DEFAULT NULL, CHANGE email_code email_code VARCHAR(40) NOT NULL, CHANGE phone_code phone_code VARCHAR(40) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE phone_nr phone_nr VARCHAR(12) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE act_code CHANGE user_id user_id INT DEFAULT NULL, CHANGE email_code email_code VARCHAR(13) NOT NULL COLLATE utf8_unicode_ci, CHANGE phone_code phone_code VARCHAR(6) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE car CHANGE image image VARCHAR(25) DEFAULT \'NULL\' COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE phone_nr phone_nr VARCHAR(12) DEFAULT \'NULL\' COLLATE utf8_unicode_ci');
    }
}
