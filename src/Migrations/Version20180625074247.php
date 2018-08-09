<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180625074247 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registrations_dogs (registration_id INT NOT NULL, dog_id INT NOT NULL, INDEX IDX_97DAFB0D833D8F43 (registration_id), UNIQUE INDEX UNIQ_97DAFB0D634DFEB (dog_id), PRIMARY KEY(registration_id, dog_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registrations_shows (registration_id INT NOT NULL, show_id INT NOT NULL, INDEX IDX_40408EDA833D8F43 (registration_id), UNIQUE INDEX UNIQ_40408EDAD0C1FC64 (show_id), PRIMARY KEY(registration_id, show_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registrations_classes (registration_id INT NOT NULL, showClass_id INT NOT NULL, INDEX IDX_2D959987833D8F43 (registration_id), UNIQUE INDEX UNIQ_2D9599876CA5D8 (showClass_id), PRIMARY KEY(registration_id, showClass_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registrations_competitions (registration_id INT NOT NULL, competition_id INT NOT NULL, INDEX IDX_86B83510833D8F43 (registration_id), UNIQUE INDEX UNIQ_86B835107B39D312 (competition_id), PRIMARY KEY(registration_id, competition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registrations_dogs ADD CONSTRAINT FK_97DAFB0D833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_dogs ADD CONSTRAINT FK_97DAFB0D634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id)');
        $this->addSql('ALTER TABLE registrations_shows ADD CONSTRAINT FK_40408EDA833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_shows ADD CONSTRAINT FK_40408EDAD0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id)');
        $this->addSql('ALTER TABLE registrations_classes ADD CONSTRAINT FK_2D959987833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_classes ADD CONSTRAINT FK_2D9599876CA5D8 FOREIGN KEY (showClass_id) REFERENCES show_class (id)');
        $this->addSql('ALTER TABLE registrations_competitions ADD CONSTRAINT FK_86B83510833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('ALTER TABLE registrations_competitions ADD CONSTRAINT FK_86B835107B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id)');
        $this->addSql('DROP TABLE registration_show');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1833D8F43');
        $this->addSql('DROP INDEX IDX_B50A2CB1833D8F43 ON competition');
        $this->addSql('ALTER TABLE competition DROP registration_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE registration_show (registration_id INT NOT NULL, show_id INT NOT NULL, INDEX IDX_FD30CEDD833D8F43 (registration_id), INDEX IDX_FD30CEDDD0C1FC64 (show_id), PRIMARY KEY(registration_id, show_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE registration_show ADD CONSTRAINT FK_FD30CEDD833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE registration_show ADD CONSTRAINT FK_FD30CEDDD0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE registrations_dogs');
        $this->addSql('DROP TABLE registrations_shows');
        $this->addSql('DROP TABLE registrations_classes');
        $this->addSql('DROP TABLE registrations_competitions');
        $this->addSql('ALTER TABLE competition ADD registration_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id)');
        $this->addSql('CREATE INDEX IDX_B50A2CB1833D8F43 ON competition (registration_id)');
    }
}
