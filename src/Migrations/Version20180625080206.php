<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625080206 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registrations_dogs DROP INDEX IDX_97DAFB0D833D8F43, ADD UNIQUE INDEX UNIQ_97DAFB0D833D8F43 (registration_id)');
        $this->addSql('ALTER TABLE registrations_shows DROP INDEX UNIQ_40408EDAD0C1FC64, ADD INDEX IDX_40408EDAD0C1FC64 (show_id)');
        $this->addSql('ALTER TABLE registrations_shows DROP INDEX IDX_40408EDA833D8F43, ADD UNIQUE INDEX UNIQ_40408EDA833D8F43 (registration_id)');
        $this->addSql('ALTER TABLE registrations_classes DROP INDEX UNIQ_2D9599876CA5D8, ADD INDEX IDX_2D9599876CA5D8 (showClass_id)');
        $this->addSql('ALTER TABLE registrations_classes DROP INDEX IDX_2D959987833D8F43, ADD UNIQUE INDEX UNIQ_2D959987833D8F43 (registration_id)');
        $this->addSql('ALTER TABLE registrations_competitions DROP INDEX UNIQ_86B835107B39D312, ADD INDEX IDX_86B835107B39D312 (competition_id)');
        $this->addSql('ALTER TABLE registrations_competitions DROP INDEX IDX_86B83510833D8F43, ADD UNIQUE INDEX UNIQ_86B83510833D8F43 (registration_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE registrations_classes DROP INDEX UNIQ_2D959987833D8F43, ADD INDEX IDX_2D959987833D8F43 (registration_id)');
        $this->addSql('ALTER TABLE registrations_classes DROP INDEX IDX_2D9599876CA5D8, ADD UNIQUE INDEX UNIQ_2D9599876CA5D8 (showClass_id)');
        $this->addSql('ALTER TABLE registrations_competitions DROP INDEX UNIQ_86B83510833D8F43, ADD INDEX IDX_86B83510833D8F43 (registration_id)');
        $this->addSql('ALTER TABLE registrations_competitions DROP INDEX IDX_86B835107B39D312, ADD UNIQUE INDEX UNIQ_86B835107B39D312 (competition_id)');
        $this->addSql('ALTER TABLE registrations_dogs DROP INDEX UNIQ_97DAFB0D833D8F43, ADD INDEX IDX_97DAFB0D833D8F43 (registration_id)');
        $this->addSql('ALTER TABLE registrations_shows DROP INDEX UNIQ_40408EDA833D8F43, ADD INDEX IDX_40408EDA833D8F43 (registration_id)');
        $this->addSql('ALTER TABLE registrations_shows DROP INDEX IDX_40408EDAD0C1FC64, ADD UNIQUE INDEX UNIQ_40408EDAD0C1FC64 (show_id)');
    }
}
