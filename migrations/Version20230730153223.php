<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230730153223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, bio LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE avis_client ADD category_id INT DEFAULT NULL, ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE avis_client ADD CONSTRAINT FK_708E90EF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE avis_client ADD CONSTRAINT FK_708E90EFF675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('CREATE INDEX IDX_708E90EF12469DE2 ON avis_client (category_id)');
        $this->addSql('CREATE INDEX IDX_708E90EFF675F31B ON avis_client (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis_client DROP FOREIGN KEY FK_708E90EFF675F31B');
        $this->addSql('DROP TABLE author');
        $this->addSql('ALTER TABLE avis_client DROP FOREIGN KEY FK_708E90EF12469DE2');
        $this->addSql('DROP INDEX IDX_708E90EF12469DE2 ON avis_client');
        $this->addSql('DROP INDEX IDX_708E90EFF675F31B ON avis_client');
        $this->addSql('ALTER TABLE avis_client DROP category_id, DROP author_id');
    }
}
