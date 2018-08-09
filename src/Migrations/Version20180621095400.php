<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180621095400 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registrations (id INT AUTO_INCREMENT NOT NULL, in_catalogue TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shows_registrations (show_id INT NOT NULL, registration_id INT NOT NULL, INDEX IDX_5CE67FC0D0C1FC64 (show_id), INDEX IDX_5CE67FC0833D8F43 (registration_id), PRIMARY KEY(show_id, registration_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_class (id INT AUTO_INCREMENT NOT NULL, class_title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shows_registrations ADD CONSTRAINT FK_5CE67FC0D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shows_registrations ADD CONSTRAINT FK_5CE67FC0833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE registration');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_427292FAE7927C74 ON owners (email)');
        $this->addSql('ALTER TABLE competition ADD competition_title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `show` ADD date_show DATETIME NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE shows_registrations DROP FOREIGN KEY FK_5CE67FC0833D8F43');
        $this->addSql('ALTER TABLE shows_registrations DROP FOREIGN KEY FK_5CE67FC0D0C1FC64');
        $this->addSql('CREATE TABLE registration (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE registrations');
        $this->addSql('DROP TABLE shows_registrations');
        $this->addSql('DROP TABLE show_class');
        $this->addSql('ALTER TABLE competition DROP competition_title');
        $this->addSql('DROP INDEX UNIQ_427292FAE7927C74 ON owners');
        $this->addSql('ALTER TABLE `show` DROP date_show, DROP city, DROP country');
    }
}
