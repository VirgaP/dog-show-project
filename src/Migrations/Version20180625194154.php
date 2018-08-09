<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625194154 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dogs CHANGE registered_name registered_name VARCHAR(100) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_353BEEB3822B330A ON dogs (pedigree_reg_no)');
        $this->addSql('ALTER TABLE show_class DROP FOREIGN KEY FK_EFFA7D43833D8F43');
        $this->addSql('DROP INDEX IDX_EFFA7D43833D8F43 ON show_class');
        $this->addSql('ALTER TABLE show_class DROP registration_id');
        $this->addSql('ALTER TABLE registrations DROP INDEX IDX_53DE51E7634DFEB, ADD UNIQUE INDEX UNIQ_53DE51E7634DFEB (dog_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_353BEEB3822B330A ON dogs');
        $this->addSql('ALTER TABLE dogs CHANGE registered_name registered_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE registrations DROP INDEX UNIQ_53DE51E7634DFEB, ADD INDEX IDX_53DE51E7634DFEB (dog_id)');
        $this->addSql('ALTER TABLE show_class ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE show_class ADD CONSTRAINT FK_EFFA7D43833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_EFFA7D43833D8F43 ON show_class (registration_id)');
    }
}
