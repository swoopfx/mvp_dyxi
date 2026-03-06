<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260306132639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_bracket (id INT AUTO_INCREMENT NOT NULL, age_id INT DEFAULT NULL, language_id INT DEFAULT NULL, bracket_id VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, bg_id VARCHAR(255) DEFAULT NULL, description LONGTEXT, bracket_name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE INDEX UNIQ_D4CC59416E8D78 (bracket_id), UNIQUE INDEX UNIQ_D4CC5941D17F50A6 (uuid), INDEX IDX_D4CC5941CC80CD12 (age_id), INDEX IDX_D4CC594182F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_bracket ADD CONSTRAINT FK_D4CC5941CC80CD12 FOREIGN KEY (age_id) REFERENCES game_age_bracket (id)');
        $this->addSql('ALTER TABLE game_bracket ADD CONSTRAINT FK_D4CC594182F1BAF4 FOREIGN KEY (language_id) REFERENCES game_language (id)');
        $this->addSql('ALTER TABLE game ADD gameBracket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD009EEB7 FOREIGN KEY (gameBracket_id) REFERENCES game_bracket (id)');
        $this->addSql('CREATE INDEX IDX_232B318CD009EEB7 ON game (gameBracket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD009EEB7');
        $this->addSql('ALTER TABLE game_bracket DROP FOREIGN KEY FK_D4CC5941CC80CD12');
        $this->addSql('ALTER TABLE game_bracket DROP FOREIGN KEY FK_D4CC594182F1BAF4');
        $this->addSql('DROP TABLE game_bracket');
        $this->addSql('DROP INDEX IDX_232B318CD009EEB7 ON game');
        $this->addSql('ALTER TABLE game DROP gameBracket_id');
    }
}
