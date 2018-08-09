<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180621100046 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owners CHANGE email email VARCHAR(171) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_427292FAE7927C74 ON owners (email)');
        $this->addSql('ALTER TABLE competition ADD competition_title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `show` ADD date_show DATETIME NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD country VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE competition DROP competition_title');
        $this->addSql('DROP INDEX UNIQ_427292FAE7927C74 ON owners');
        $this->addSql('ALTER TABLE owners CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE `show` DROP date_show, DROP city, DROP country');
    }
}
