<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180720084534 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113833D8F43');
        $this->addSql('DROP INDEX IDX_136AC113833D8F43 ON result');
        $this->addSql('ALTER TABLE result CHANGE registration_id diploma_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113A99ACEB5 FOREIGN KEY (diploma_id) REFERENCES diploma (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_136AC113A99ACEB5 ON result (diploma_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113A99ACEB5');
        $this->addSql('DROP INDEX UNIQ_136AC113A99ACEB5 ON result');
        $this->addSql('ALTER TABLE result CHANGE diploma_id registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_136AC113833D8F43 ON result (registration_id)');
    }
}
