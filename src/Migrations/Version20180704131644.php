<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180704131644 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_427292FAE7927C74 ON owners');
        $this->addSql('ALTER TABLE owners ADD user_id INT DEFAULT NULL, DROP email, DROP password, DROP roles');
        $this->addSql('ALTER TABLE owners ADD CONSTRAINT FK_427292FAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_427292FAA76ED395 ON owners (user_id)');
        $this->addSql('ALTER TABLE user ADD password VARCHAR(60) NOT NULL, ADD email VARCHAR(65) NOT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD created_at DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE owners DROP FOREIGN KEY FK_427292FAA76ED395');
        $this->addSql('DROP INDEX UNIQ_427292FAA76ED395 ON owners');
        $this->addSql('ALTER TABLE owners ADD email VARCHAR(171) NOT NULL COLLATE utf8mb4_unicode_ci, ADD password VARCHAR(60) NOT NULL COLLATE utf8mb4_unicode_ci, ADD roles LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\', DROP user_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_427292FAE7927C74 ON owners (email)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user DROP password, DROP email, DROP roles, DROP created_at');
    }
}
