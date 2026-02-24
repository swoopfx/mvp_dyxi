<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224220846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, teacher_id VARCHAR(255) DEFAULT NULL, student_name VARCHAR(255) DEFAULT NULL, student_age INT DEFAULT NULL, student_id VARCHAR(255) NOT NULL, is_dyslexic TINYINT(1) DEFAULT 0 NOT NULL, uuid VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_A4698DB2CB944F1A (student_id), UNIQUE INDEX UNIQ_A4698DB2D17F50A6 (uuid), INDEX IDX_A4698DB241807E1D (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, teacher_name VARCHAR(255) NOT NULL, teacher_id VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_B0F6A6D5D17F50A6 (uuid), UNIQUE INDEX teacher_id_unique (teacher_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB241807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (teacher_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB241807E1D');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE teacher');
    }
}
