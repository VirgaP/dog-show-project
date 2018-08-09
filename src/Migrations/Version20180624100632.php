<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180624100632 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition ADD competition_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB17B39D312 FOREIGN KEY (competition_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB17B39D312 ON competition (competition_id)');
        $this->addSql('ALTER TABLE show_class ADD showClass_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE show_class ADD CONSTRAINT FK_EFFA7D436CA5D8 FOREIGN KEY (showClass_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_EFFA7D436CA5D8 ON show_class (showClass_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB17B39D312');
        $this->addSql('DROP INDEX IDX_B50A2CB17B39D312 ON competition');
        $this->addSql('ALTER TABLE competition DROP competition_id');
        $this->addSql('ALTER TABLE show_class DROP FOREIGN KEY FK_EFFA7D436CA5D8');
        $this->addSql('DROP INDEX IDX_EFFA7D436CA5D8 ON show_class');
        $this->addSql('ALTER TABLE show_class DROP showClass_id');
    }
}
