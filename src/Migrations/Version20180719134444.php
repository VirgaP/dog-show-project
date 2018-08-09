<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180719134444 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE shows_judges (show_id INT NOT NULL, judges_id INT NOT NULL, INDEX IDX_317D5DCCD0C1FC64 (show_id), INDEX IDX_317D5DCC10A43C19 (judges_id), PRIMARY KEY(show_id, judges_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diploma (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shows_judges ADD CONSTRAINT FK_317D5DCCD0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shows_judges ADD CONSTRAINT FK_317D5DCC10A43C19 FOREIGN KEY (judges_id) REFERENCES judges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e0833d8f43 TO IDX_2A4E3FC7833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_ff8ab7e03da5256d TO IDX_2A4E3FC73DA5256D');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE shows_judges');
        $this->addSql('DROP TABLE diploma');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc7833d8f43 TO IDX_FF8AB7E0833D8F43');
        $this->addSql('ALTER TABLE registrations_files RENAME INDEX idx_2a4e3fc73da5256d TO IDX_FF8AB7E03DA5256D');
    }
}
