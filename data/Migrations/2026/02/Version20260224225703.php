<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260224225703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB241807E1D');
        $this->addSql('DROP INDEX IDX_A4698DB241807E1D ON students');
        $this->addSql('ALTER TABLE students ADD teacherId_id INT DEFAULT NULL, DROP teacher_id');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2C21CA679 FOREIGN KEY (teacherId_id) REFERENCES teacher (id)');
        $this->addSql('CREATE INDEX IDX_A4698DB2C21CA679 ON students (teacherId_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2C21CA679');
        $this->addSql('DROP INDEX IDX_A4698DB2C21CA679 ON students');
        $this->addSql('ALTER TABLE students ADD teacher_id VARCHAR(255) DEFAULT NULL, DROP teacherId_id');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB241807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (teacher_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_A4698DB241807E1D ON students (teacher_id)');
    }
}
