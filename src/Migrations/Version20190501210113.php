<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190501210113 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ride (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, car_id INT NOT NULL, pick_up VARCHAR(255) NOT NULL, drop_off VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, pick_up_date DATETIME NOT NULL, pick_up_time TIME NOT NULL, duration INT NOT NULL, drop_off_time TIME NOT NULL, INDEX IDX_9B3D7CD0A76ED395 (user_id), UNIQUE INDEX UNIQ_9B3D7CD0C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, brand VARCHAR(50) NOT NULL, model VARCHAR(50) NOT NULL, image VARCHAR(25) DEFAULT NULL, is_chating TINYINT(1) NOT NULL, is_smoking TINYINT(1) NOT NULL, is_music TINYINT(1) NOT NULL, is_pets TINYINT(1) NOT NULL, max_passangers INT NOT NULL, INDEX IDX_773DE69DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE act_code (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, email_code VARCHAR(13) NOT NULL, phone_code VARCHAR(6) NOT NULL, UNIQUE INDEX UNIQ_BF9CD17DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(40) NOT NULL, last_name VARCHAR(40) NOT NULL, phone_nr VARCHAR(12) DEFAULT NULL, date_of_birth DATE NOT NULL, is_email TINYINT(1) NOT NULL, is_phone TINYINT(1) NOT NULL, photo VARCHAR(23) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE act_code ADD CONSTRAINT FK_BF9CD17DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD0C3C6F69F');
        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD0A76ED395');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DA76ED395');
        $this->addSql('ALTER TABLE act_code DROP FOREIGN KEY FK_BF9CD17DA76ED395');
        $this->addSql('DROP TABLE ride');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE act_code');
        $this->addSql('DROP TABLE user');
    }
}