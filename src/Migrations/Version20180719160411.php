<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180719160411 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, grade VARCHAR(100) DEFAULT NULL, place INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e0833d8f43 TO IDX_2A4E3FC7833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e03da5256d TO IDX_2A4E3FC73DA5256D');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE result');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc7833d8f43 TO IDX_FF8AB7E0833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc73da5256d TO IDX_FF8AB7E03DA5256D');
    }
}
