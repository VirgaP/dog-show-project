<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180719170803 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diploma ADD date DATETIME NOT NULL, ADD number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE result ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_136AC113833D8F43 ON result (registration_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diploma DROP date, DROP number');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113833D8F43');
        $this->addSql('DROP INDEX IDX_136AC113833D8F43 ON result');
        $this->addSql('ALTER TABLE result DROP registration_id');
    }
}
