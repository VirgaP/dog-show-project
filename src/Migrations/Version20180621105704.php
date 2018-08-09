<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180621105704 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, dog_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_C53D045F634DFEB (dog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_C53D045F634DFEB FOREIGN KEY (dog_id) REFERENCES dogs (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE images');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_C53D045F634DFEB4');
    }
}
