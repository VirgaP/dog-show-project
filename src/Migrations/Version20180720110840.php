<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180720110840 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE diploma_titles (diploma_id INT NOT NULL, title_id INT NOT NULL, INDEX IDX_87B3CC3DA99ACEB5 (diploma_id), UNIQUE INDEX UNIQ_87B3CC3DA9F87BD (title_id), PRIMARY KEY(diploma_id, title_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diploma_titles ADD CONSTRAINT FK_87B3CC3DA99ACEB5 FOREIGN KEY (diploma_id) REFERENCES diploma (id)');
        $this->addSql('ALTER TABLE diploma_titles ADD CONSTRAINT FK_87B3CC3DA9F87BD FOREIGN KEY (title_id) REFERENCES title (id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE diploma_titles');

    }
}
