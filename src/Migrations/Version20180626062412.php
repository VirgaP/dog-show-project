<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626062412 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registration_classes (registration_id INT NOT NULL, class_id INT NOT NULL, INDEX IDX_429C2B63833D8F43 (registration_id), INDEX IDX_429C2B63EA000B10 (class_id), PRIMARY KEY(registration_id, class_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registration_competitions (registration_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_1239EF9833D8F43 (registration_id), INDEX IDX_1239EF97B39D312 (competition_id), PRIMARY KEY(registration_id, competition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registration_classes ADD CONSTRAINT FK_429C2B63EA000B10 FOREIGN KEY (class_id) REFERENCES show_class (id)');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF9833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registration_competitions ADD CONSTRAINT FK_1239EF97B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('DROP TABLE registrations_classes');
        $this->addSql('DROP TABLE registrations_competitions');
        $this->addSql('DROP TABLE registrations_dogs');
        $this->addSql('DROP TABLE registrations_shows');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1833D8F43');
        $this->addSql('DROP INDEX IDX_B50A2CB1833D8F43 ON competition');
        $this->addSql('ALTER TABLE competition DROP registration_id');
        $this->addSql('ALTER TABLE dogs CHANGE registered_name registered_name VARCHAR(100) NOT NULL, CHANGE pedigree_reg_no pedigree_reg_no VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_353BEEB3822B330A ON dogs (pedigree_reg_no)');
        $this->addSql('ALTER TABLE registrations ADD dog_id INT DEFAULT NULL, ADD show_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registrations ADD CONSTRAINT FK_53DE51E7634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id)');
        $this->addSql('ALTER TABLE registrations ADD CONSTRAINT FK_53DE51E7D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_53DE51E7634DFEB ON registrations (dog_id)');
        $this->addSql('CREATE INDEX IDX_53DE51E7D0C1FC64 ON registrations (show_id)');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED901833D8F43');
        $this->addSql('DROP INDEX IDX_320ED901833D8F43 ON `show`');
        $this->addSql('ALTER TABLE `show` DROP registration_id');
        $this->addSql('ALTER TABLE show_class DROP FOREIGN KEY FK_EFFA7D43833D8F43');
        $this->addSql('DROP INDEX IDX_EFFA7D43833D8F43 ON show_class');
        $this->addSql('ALTER TABLE show_class DROP registration_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registrations_classes (registration_id INT NOT NULL, showClass_id INT NOT NULL, INDEX IDX_2D9599876CA5D8 (showClass_id), INDEX IDX_2D959987833D8F43 (registration_id), PRIMARY KEY(registration_id, showClass_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registrations_competitions (registration_id INT NOT NULL, competition_id INT NOT NULL, UNIQUE INDEX UNIQ_86B83510833D8F43 (registration_id), INDEX IDX_86B835107B39D312 (competition_id), PRIMARY KEY(registration_id, competition_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registrations_dogs (registration_id INT NOT NULL, dog_id INT NOT NULL, UNIQUE INDEX UNIQ_97DAFB0D634DFEB (dog_id), UNIQUE INDEX UNIQ_97DAFB0D833D8F43 (registration_id), PRIMARY KEY(registration_id, dog_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registrations_shows (registration_id INT NOT NULL, show_id INT NOT NULL, UNIQUE INDEX UNIQ_40408EDA833D8F43 (registration_id), INDEX IDX_40408EDAD0C1FC64 (show_id), PRIMARY KEY(registration_id, show_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registrations_classes ADD CONSTRAINT FK_2D9599876CA5D8 FOREIGN KEY (showClass_id) REFERENCES show_class (id)');
        $this->addSql('ALTER TABLE registrations_classes ADD CONSTRAINT FK_2D959987833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_competitions ADD CONSTRAINT FK_86B835107B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('ALTER TABLE registrations_competitions ADD CONSTRAINT FK_86B83510833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_dogs ADD CONSTRAINT FK_97DAFB0D634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id)');
        $this->addSql('ALTER TABLE registrations_dogs ADD CONSTRAINT FK_97DAFB0D833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_shows ADD CONSTRAINT FK_40408EDA833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_shows ADD CONSTRAINT FK_40408EDAD0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id)');
        $this->addSql('DROP TABLE registration_classes');
        $this->addSql('DROP TABLE registration_competitions');
        $this->addSql('ALTER TABLE competition ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB1833D8F43 ON competition (registration_id)');
        $this->addSql('DROP INDEX UNIQ_353BEEB3822B330A ON dogs');
        $this->addSql('ALTER TABLE dogs CHANGE registered_name registered_name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE pedigree_reg_no pedigree_reg_no VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE registrations DROP FOREIGN KEY FK_53DE51E7634DFEB');
        $this->addSql('ALTER TABLE registrations DROP FOREIGN KEY FK_53DE51E7D0C1FC64');
        $this->addSql('DROP INDEX UNIQ_53DE51E7634DFEB ON registrations');
        $this->addSql('DROP INDEX IDX_53DE51E7D0C1FC64 ON registrations');
        $this->addSql('ALTER TABLE registrations DROP dog_id, DROP show_id');
        $this->addSql('ALTER TABLE `show` ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED901833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_320ED901833D8F43 ON `show` (registration_id)');
        $this->addSql('ALTER TABLE show_class ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE show_class ADD CONSTRAINT FK_EFFA7D43833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_EFFA7D43833D8F43 ON show_class (registration_id)');
    }
}
