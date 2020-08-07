<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200805013934 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE joke (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, setup VARCHAR(255) NOT NULL, punchline VARCHAR(255) NOT NULL, laughs INTEGER NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE joke');
    }

    public function postUp(Schema $schema) : void
    {
        // This will pre-populate some joke data into the database after the tabe has been created (after the up function has been called)
        $this->connection->insert('joke', ['id' => 1, 'setup' => 'Foo', 'punchline' => 'Bar', 'laughs' => 1]);
    }

    
}
