<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260306131828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eye_tracking_data (id INT AUTO_INCREMENT NOT NULL, eye_tracking_data LONGTEXT, session_id VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, gameId_id INT DEFAULT NULL, studentId_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_BC3754DFD17F50A6 (uuid), INDEX IDX_BC3754DF8B5AD64 (gameId_id), INDEX IDX_BC3754DFDC83BA90 (studentId_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE frequency_data_type (id INT AUTO_INCREMENT NOT NULL, frequency_data_type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, game_name VARCHAR(255) DEFAULT NULL, game_page VARCHAR(255) DEFAULT NULL, game_definition LONGTEXT, uuid VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, gamesType_id INT DEFAULT NULL, gameCategory_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_232B318CD17F50A6 (uuid), INDEX IDX_232B318C31EABD39 (gamesType_id), INDEX IDX_232B318C194D25A0 (gameCategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_age_bracket (id INT AUTO_INCREMENT NOT NULL, age VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_category (id INT AUTO_INCREMENT NOT NULL, game_category VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_language (id INT AUTO_INCREMENT NOT NULL, language VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eye_tracking_data ADD CONSTRAINT FK_BC3754DF8B5AD64 FOREIGN KEY (gameId_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE eye_tracking_data ADD CONSTRAINT FK_BC3754DFDC83BA90 FOREIGN KEY (studentId_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C31EABD39 FOREIGN KEY (gamesType_id) REFERENCES game_type (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C194D25A0 FOREIGN KEY (gameCategory_id) REFERENCES game_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eye_tracking_data DROP FOREIGN KEY FK_BC3754DF8B5AD64');
        $this->addSql('ALTER TABLE eye_tracking_data DROP FOREIGN KEY FK_BC3754DFDC83BA90');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C31EABD39');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C194D25A0');
        $this->addSql('DROP TABLE eye_tracking_data');
        $this->addSql('DROP TABLE frequency_data_type');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_age_bracket');
        $this->addSql('DROP TABLE game_category');
        $this->addSql('DROP TABLE game_language');
        $this->addSql('DROP TABLE game_type');
    }
}
