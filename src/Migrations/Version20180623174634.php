<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180623174634 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dogs (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, registered_name VARCHAR(255) NOT NULL, pedigree_reg_no VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, chip_tattoo_no VARCHAR(255) NOT NULL, sire VARCHAR(255) NOT NULL, dam VARCHAR(255) NOT NULL, breeder VARCHAR(255) NOT NULL, name_of_club VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_353BEEB37E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_class (id INT AUTO_INCREMENT NOT NULL, class_title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owners (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(171) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_427292FAE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE title (id INT AUTO_INCREMENT NOT NULL, dog_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, date DATE DEFAULT NULL, competition VARCHAR(255) DEFAULT NULL, INDEX IDX_2B36786B634DFEB (dog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `show` (id INT AUTO_INCREMENT NOT NULL, date_show DATETIME NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shows_registrations (show_id INT NOT NULL, registration_id INT NOT NULL, INDEX IDX_5CE67FC0D0C1FC64 (show_id), INDEX IDX_5CE67FC0833D8F43 (registration_id), PRIMARY KEY(show_id, registration_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, competition_title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registrations (id INT AUTO_INCREMENT NOT NULL, in_catalogue TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, dog_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, file_name VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A634DFEB (dog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB37E3C61F9 FOREIGN KEY (owner_id) REFERENCES owners (id)');
        $this->addSql('ALTER TABLE title ADD CONSTRAINT FK_2B36786B634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id)');
        $this->addSql('ALTER TABLE shows_registrations ADD CONSTRAINT FK_5CE67FC0D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE shows_registrations ADD CONSTRAINT FK_5CE67FC0833D8F43 FOREIGN KEY (registration_id) REFERENCES registrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE title DROP FOREIGN KEY FK_2B36786B634DFEB');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A634DFEB');
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB37E3C61F9');
        $this->addSql('ALTER TABLE shows_registrations DROP FOREIGN KEY FK_5CE67FC0D0C1FC64');
        $this->addSql('ALTER TABLE shows_registrations DROP FOREIGN KEY FK_5CE67FC0833D8F43');
        $this->addSql('DROP TABLE dogs');
        $this->addSql('DROP TABLE show_class');
        $this->addSql('DROP TABLE owners');
        $this->addSql('DROP TABLE title');
        $this->addSql('DROP TABLE `show`');
        $this->addSql('DROP TABLE shows_registrations');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE registrations');
        $this->addSql('DROP TABLE images');
    }
}
