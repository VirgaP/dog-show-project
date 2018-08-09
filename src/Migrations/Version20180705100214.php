<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180705100214 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registrations_files (registration_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_FF8AB7E0833D8F43 (registration_id), INDEX IDX_FF8AB7E03DA5256D (image_id), PRIMARY KEY(registration_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registrations_files ADD CONSTRAINT FK_FF8AB7E0833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registrations_files ADD CONSTRAINT FK_FF8AB7E03DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A833D8F43');
        $this->addSql('DROP INDEX IDX_E01FBE6A833D8F43 ON images');
        $this->addSql('ALTER TABLE images DROP registration_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE registrations_files');
        $this->addSql('ALTER TABLE images ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A833D8F43 ON images (registration_id)');
    }
}
