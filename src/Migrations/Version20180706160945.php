<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180706160945 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registrations_files (registration_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_2A4E3FC7833D8F43 (registration_id), INDEX IDX_2A4E3FC73DA5256D (image_id), PRIMARY KEY(registration_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registrations_files ADD CONSTRAINT FK_2A4E3FC7833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registrations_files ADD CONSTRAINT FK_2A4E3FC73DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_427292FAE7927C74 ON owners');
        $this->addSql('ALTER TABLE owners ADD user_id INT DEFAULT NULL, DROP email, DROP password, DROP roles');
        $this->addSql('ALTER TABLE owners ADD CONSTRAINT FK_427292FAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_427292FAA76ED395 ON owners (user_id)');
        $this->addSql('ALTER TABLE user ADD password VARCHAR(60) NOT NULL, ADD email VARCHAR(65) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD created_at DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
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
        $this->addSql('ALTER TABLE owners DROP FOREIGN KEY FK_427292FAA76ED395');
        $this->addSql('DROP INDEX UNIQ_427292FAA76ED395 ON owners');
        $this->addSql('ALTER TABLE owners ADD email VARCHAR(171) NOT NULL COLLATE utf8mb4_unicode_ci, ADD password VARCHAR(60) NOT NULL COLLATE utf8mb4_unicode_ci, ADD roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', DROP user_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_427292FAE7927C74 ON owners (email)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP password, DROP email, DROP roles, DROP created_at');
    }
}
