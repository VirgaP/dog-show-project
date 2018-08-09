<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180719162149 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e0833d8f43 TO IDX_2A4E3FC7833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e03da5256d TO IDX_2A4E3FC73DA5256D');
        $this->addSql('ALTER TABLE result ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC1134584665A FOREIGN KEY (product_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_136AC1134584665A ON result (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc7833d8f43 TO IDX_FF8AB7E0833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc73da5256d TO IDX_FF8AB7E03DA5256D');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC1134584665A');
        $this->addSql('DROP INDEX IDX_136AC1134584665A ON result');
        $this->addSql('ALTER TABLE result DROP product_id');
    }
}
