<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180626063349 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

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

        $this->addSql('DROP INDEX UNIQ_353BEEB3822B330A ON dogs');
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
