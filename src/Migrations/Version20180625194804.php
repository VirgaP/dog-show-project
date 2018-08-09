<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625194804 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registrations DROP INDEX IDX_53DE51E7D0C1FC64, ADD UNIQUE INDEX UNIQ_53DE51E7D0C1FC64 (show_id)');
        $this->addSql('ALTER TABLE registration_classes DROP INDEX UNIQ_429C2B63EA000B10, ADD INDEX IDX_429C2B63EA000B10 (class_id)');
        $this->addSql('ALTER TABLE registration_competitions DROP INDEX UNIQ_1239EF97B39D312, ADD INDEX IDX_1239EF97B39D312 (competition_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_353BEEB3822B330A ON dogs (pedigree_reg_no)');
        $this->addSql('ALTER TABLE show_class DROP FOREIGN KEY FK_EFFA7D43833D8F43');
        $this->addSql('DROP INDEX IDX_EFFA7D43833D8F43 ON show_class');
        $this->addSql('ALTER TABLE show_class DROP registration_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_353BEEB3822B330A ON dogs');
        $this->addSql('ALTER TABLE registration_classes DROP INDEX IDX_429C2B63EA000B10, ADD UNIQUE INDEX UNIQ_429C2B63EA000B10 (class_id)');
        $this->addSql('ALTER TABLE registration_competitions DROP INDEX IDX_1239EF97B39D312, ADD UNIQUE INDEX UNIQ_1239EF97B39D312 (competition_id)');
        $this->addSql('ALTER TABLE registrations DROP INDEX UNIQ_53DE51E7D0C1FC64, ADD INDEX IDX_53DE51E7D0C1FC64 (show_id)');
        $this->addSql('ALTER TABLE show_class ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE show_class ADD CONSTRAINT FK_EFFA7D43833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_EFFA7D43833D8F43 ON show_class (registration_id)');
    }
}
