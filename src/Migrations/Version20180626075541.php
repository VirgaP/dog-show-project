<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626075541 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registration_classes DROP FOREIGN KEY FK_429C2B63833D8F43');
        $this->addSql('ALTER TABLE registration_classes DROP FOREIGN KEY FK_429C2B63EA000B10');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63EA000B10 FOREIGN KEY (class_id) REFERENCES show_class (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF97B39D312');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF9833D8F43');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF9833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registration_classes DROP FOREIGN KEY FK_429C2B63833D8F43');
        $this->addSql('ALTER TABLE registration_classes DROP FOREIGN KEY FK_429C2B63EA000B10');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63EA000B10 FOREIGN KEY (class_id) REFERENCES show_class (id)');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF9833D8F43');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF97B39D312');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF9833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
    }
}
