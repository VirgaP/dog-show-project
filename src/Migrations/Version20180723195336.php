<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180723195336 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE diploma (id INT AUTO_INCREMENT NOT NULL, registration_id INT DEFAULT NULL, date DATETIME NOT NULL, number VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EC218957833D8F43 (registration_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diploma_titles (diploma_id INT NOT NULL, title_id INT NOT NULL, INDEX IDX_87B3CC3DA99ACEB5 (diploma_id), UNIQUE INDEX UNIQ_87B3CC3DA9F87BD (title_id), PRIMARY KEY(diploma_id, title_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shows_judges (show_id INT NOT NULL, judges_id INT NOT NULL, INDEX IDX_317D5DCCD0C1FC64 (show_id), INDEX IDX_317D5DCC10A43C19 (judges_id), PRIMARY KEY(show_id, judges_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, diploma_id INT DEFAULT NULL, grade VARCHAR(100) DEFAULT NULL, place INT DEFAULT NULL, UNIQUE INDEX UNIQ_136AC113A99ACEB5 (diploma_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diploma ADD CONSTRAINT FK_EC218957833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE diploma_titles ADD CONSTRAINT FK_87B3CC3DA99ACEB5 FOREIGN KEY (diploma_id) REFERENCES diploma (id)');
        $this->addSql('ALTER TABLE diploma_titles ADD CONSTRAINT FK_87B3CC3DA9F87BD FOREIGN KEY (title_id) REFERENCES title (id)');
        $this->addSql('ALTER TABLE shows_judges ADD CONSTRAINT FK_317D5DCCD0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shows_judges ADD CONSTRAINT FK_317D5DCC10A43C19 FOREIGN KEY (judges_id) REFERENCES judges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113A99ACEB5 FOREIGN KEY (diploma_id) REFERENCES diploma (id)');
        $this->addSql('ALTER TABLE title DROP date, DROP competition');
        $this->addSql('ALTER TABLE `show` ADD show_name LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE diploma_titles DROP FOREIGN KEY FK_87B3CC3DA99ACEB5');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113A99ACEB5');
        $this->addSql('DROP TABLE diploma');
        $this->addSql('DROP TABLE diploma_titles');
        $this->addSql('DROP TABLE shows_judges');
        $this->addSql('DROP TABLE result');
        $this->addSql('ALTER TABLE `show` DROP show_name');
        $this->addSql('ALTER TABLE title ADD date DATE DEFAULT NULL, ADD competition VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
