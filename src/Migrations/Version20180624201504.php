<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180624201504 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registration_show (registration_id INT NOT NULL, show_id INT NOT NULL, INDEX IDX_FD30CEDD833D8F43 (registration_id), INDEX IDX_FD30CEDDD0C1FC64 (show_id), PRIMARY KEY(registration_id, show_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_show ADD CONSTRAINT FK_FD30CEDD833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_show ADD CONSTRAINT FK_FD30CEDDD0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE registration_show');
    }
}
