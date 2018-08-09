<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625193918 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registration_classes (registration_id INT NOT NULL, class_id INT NOT NULL, INDEX IDX_429C2B63833D8F43 (registration_id), UNIQUE INDEX UNIQ_429C2B63EA000B10 (class_id), PRIMARY KEY(registration_id, class_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_competitions (registration_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_1239EF9833D8F43 (registration_id), UNIQUE INDEX UNIQ_1239EF97B39D312 (competition_id), PRIMARY KEY(registration_id, competition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63EA000B10 FOREIGN KEY (class_id) REFERENCES show_class (id)');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF9833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1833D8F43');
        $this->addSql('DROP INDEX IDX_B50A2CB1833D8F43 ON competition');
        $this->addSql('ALTER TABLE competition DROP registration_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_353BEEB3822B330A ON dogs (pedigree_reg_no)');
        $this->addSql('ALTER TABLE registrations DROP INDEX IDX_53DE51E7634DFEB, ADD UNIQUE INDEX UNIQ_53DE51E7634DFEB (dog_id)');
        $this->addSql('ALTER TABLE show_class DROP FOREIGN KEY FK_EFFA7D43833D8F43');
        $this->addSql('DROP INDEX IDX_EFFA7D43833D8F43 ON show_class');
        $this->addSql('ALTER TABLE show_class DROP registration_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE registration_classes');
        $this->addSql('DROP TABLE registration_competitions');
        $this->addSql('ALTER TABLE competition ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB1833D8F43 ON competition (registration_id)');
        $this->addSql('DROP INDEX UNIQ_353BEEB3822B330A ON dogs');
        $this->addSql('ALTER TABLE registrations DROP INDEX UNIQ_53DE51E7634DFEB, ADD INDEX IDX_53DE51E7634DFEB (dog_id)');
        $this->addSql('ALTER TABLE show_class ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE show_class ADD CONSTRAINT FK_EFFA7D43833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_EFFA7D43833D8F43 ON show_class (registration_id)');
    }
}
