<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625075153 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB1833D8F43 ON competition (registration_id)');
        $this->addSql('ALTER TABLE `show` ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED901833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_320ED901833D8F43 ON `show` (registration_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1833D8F43');
        $this->addSql('DROP INDEX IDX_B50A2CB1833D8F43 ON competition');
        $this->addSql('ALTER TABLE competition DROP registration_id');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED901833D8F43');
        $this->addSql('DROP INDEX IDX_320ED901833D8F43 ON `show`');
        $this->addSql('ALTER TABLE `show` DROP registration_id');
    }
}
