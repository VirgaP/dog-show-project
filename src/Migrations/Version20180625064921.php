<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625064921 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registration_show (registration_id INT NOT NULL, show_id INT NOT NULL, INDEX IDX_FD30CEDD833D8F43 (registration_id), INDEX IDX_FD30CEDDD0C1FC64 (show_id), PRIMARY KEY(registration_id, show_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_show ADD CONSTRAINT FK_FD30CEDD833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_show ADD CONSTRAINT FK_FD30CEDDD0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE shows_registrations');
        $this->addSql('ALTER TABLE competition ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB1833D8F43 ON competition (registration_id)');
        $this->addSql('ALTER TABLE show_class ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE show_class ADD CONSTRAINT FK_EFFA7D43833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_EFFA7D43833D8F43 ON show_class (registration_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shows_registrations (show_id INT NOT NULL, registration_id INT NOT NULL, INDEX IDX_5CE67FC0D0C1FC64 (show_id), INDEX IDX_5CE67FC0833D8F43 (registration_id), PRIMARY KEY(show_id, registration_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shows_registrations ADD CONSTRAINT FK_5CE67FC0833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shows_registrations ADD CONSTRAINT FK_5CE67FC0D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE registration_show');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1833D8F43');
        $this->addSql('DROP INDEX IDX_B50A2CB1833D8F43 ON competition');
        $this->addSql('ALTER TABLE competition DROP registration_id');
        $this->addSql('ALTER TABLE show_class DROP FOREIGN KEY FK_EFFA7D43833D8F43');
        $this->addSql('DROP INDEX IDX_EFFA7D43833D8F43 ON show_class');
        $this->addSql('ALTER TABLE show_class DROP registration_id');
    }
}
