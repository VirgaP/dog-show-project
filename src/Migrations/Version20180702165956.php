<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180702165956 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE file');
        $this->addSql('ALTER TABLE registrations DROP file_name');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A833D8F43');
        $this->addSql('DROP INDEX IDX_E01FBE6A833D8F43 ON images');
        $this->addSql('ALTER TABLE images DROP updated_at, CHANGE registration_id dog_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A634DFEB ON images (dog_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, file_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A634DFEB');
        $this->addSql('DROP INDEX IDX_E01FBE6A634DFEB ON images');
        $this->addSql('ALTER TABLE images ADD updated_at DATETIME NOT NULL, CHANGE dog_id registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A833D8F43 ON images (registration_id)');
        $this->addSql('ALTER TABLE registrations ADD file_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
