<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180708190843 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users CHANGE credential_email credential_email VARCHAR(95) NOT NULL, CHANGE credential_password credential_password VARCHAR(95) NOT NULL, CHANGE password_reset_token password_reset_token VARCHAR(55) DEFAULT NULL');
        $this->addSql('ALTER TABLE role CHANGE name name VARCHAR(55) NOT NULL');
        $this->addSql('ALTER TABLE user_role CHANGE role_name role_name VARCHAR(55) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE role CHANGE name name VARCHAR(55) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user_role CHANGE role_name role_name VARCHAR(55) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE users CHANGE credential_email credential_email VARCHAR(95) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE credential_password credential_password VARCHAR(95) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE password_reset_token password_reset_token VARCHAR(55) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
