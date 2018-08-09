<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180703123530 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE catalogue (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE registration_classes');
        $this->addSql('ALTER TABLE images ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A833D8F43 ON images (registration_id)');
        $this->addSql('ALTER TABLE registrations ADD show_class_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registrations ADD CONSTRAINT FK_53DE51E7D364EAFF FOREIGN KEY (show_class_id) REFERENCES show_class (id)');
        $this->addSql('CREATE INDEX IDX_53DE51E7D364EAFF ON registrations (show_class_id)');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF97B39D312');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF9833D8F43');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF9833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registration_classes (registration_id INT NOT NULL, class_id INT NOT NULL, INDEX IDX_429C2B63833D8F43 (registration_id), INDEX IDX_429C2B63EA000B10 (class_id), PRIMARY KEY(registration_id, class_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63EA000B10 FOREIGN KEY (class_id) REFERENCES show_class (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE catalogue');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A833D8F43');
        $this->addSql('DROP INDEX IDX_E01FBE6A833D8F43 ON images');
        $this->addSql('ALTER TABLE images DROP registration_id');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF9833D8F43');
        $this->addSql('ALTER TABLE registration_competitions DROP FOREIGN KEY FK_1239EF97B39D312');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF9833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registrations DROP FOREIGN KEY FK_53DE51E7D364EAFF');
        $this->addSql('DROP INDEX IDX_53DE51E7D364EAFF ON registrations');
        $this->addSql('ALTER TABLE registrations DROP show_class_id');
    }
}
