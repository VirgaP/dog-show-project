<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180718080511 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT DEFAULT NULL, is_published TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owners ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE owners ADD CONSTRAINT FK_427292FAA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_427292FAA76ED395 ON owners (user_id)');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e0833d8f43 TO IDX_2A4E3FC7833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e03da5256d TO IDX_2A4E3FC73DA5256D');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE post');
        $this->addSql('ALTER TABLE owners DROP FOREIGN KEY FK_427292FAA76ED395');
        $this->addSql('DROP INDEX UNIQ_427292FAA76ED395 ON owners');
        $this->addSql('ALTER TABLE owners DROP user_id');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc7833d8f43 TO IDX_FF8AB7E0833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc73da5256d TO IDX_FF8AB7E03DA5256D');
    }
}
