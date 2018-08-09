<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180620143229 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dogs ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB37E3C61F9 FOREIGN KEY (owner_id) REFERENCES owners (id)');
        $this->addSql('CREATE INDEX IDX_353BEEB37E3C61F9 ON dogs (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB37E3C61F9');
        $this->addSql('DROP INDEX IDX_353BEEB37E3C61F9 ON dogs');
        $this->addSql('ALTER TABLE dogs DROP owner_id');
    }
}
