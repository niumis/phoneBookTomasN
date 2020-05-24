<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200524174344 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('CREATE TABLE shared (id INT AUTO_INCREMENT NOT NULL, phone_book_id INT DEFAULT NULL, shared_by_user_id INT DEFAULT NULL, shared_with_user_id INT DEFAULT NULL, INDEX IDX_138CF4BB86E03FB3 (phone_book_id), INDEX IDX_138CF4BBA88FC4FB (shared_by_user_id), INDEX IDX_138CF4BB42EBB09C (shared_with_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone_book (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, full_name VARCHAR(255) NOT NULL, phone VARCHAR(17) NOT NULL, INDEX IDX_28E1F123A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shared ADD CONSTRAINT FK_138CF4BB86E03FB3 FOREIGN KEY (phone_book_id) REFERENCES phone_book (id)');
        $this->addSql('ALTER TABLE shared ADD CONSTRAINT FK_138CF4BBA88FC4FB FOREIGN KEY (shared_by_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shared ADD CONSTRAINT FK_138CF4BB42EBB09C FOREIGN KEY (shared_with_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE phone_book ADD CONSTRAINT FK_28E1F123A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE shared DROP FOREIGN KEY FK_138CF4BB86E03FB3');
        $this->addSql('ALTER TABLE shared DROP FOREIGN KEY FK_138CF4BBA88FC4FB');
        $this->addSql('ALTER TABLE shared DROP FOREIGN KEY FK_138CF4BB42EBB09C');
        $this->addSql('ALTER TABLE phone_book DROP FOREIGN KEY FK_28E1F123A76ED395');
        $this->addSql('DROP TABLE shared');
        $this->addSql('DROP TABLE phone_book');
        $this->addSql('DROP TABLE user');
    }
}
