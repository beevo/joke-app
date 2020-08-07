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
        $data = [
            ['laughs' => 0,
            'setup' => 'What do birds give out on Halloween?',
            'punchline' => 'Tweets.'],
            ['laughs' => 24,
            'setup' => 'A SQL query walks into a bar, walks up to two tables and asks...',
            'punchline' => 'Can I join you?' ],
            ['laughs' => 284,
            'setup' => 'What\'s the difference between a guitar and a fish?',
            'punchline' => "You can tune a guitar but you can't tuna fish"],
            ['laughs' => 323,
            'setup' => 'Why can’t you hear a pterodactyl go to the bathroom?',
            'punchline' => 'The p is silent.'],
            ['laughs' => 287,
            'setup' => "What's the worst part about being a cross-eyed teacher?",
            'punchline' => "They can't control their pupils."],
            ['laughs' => 361,
            'setup' => 'Why do crabs never give to charity?',
            'punchline' => 'Because they’re shellfish.'],
            ['laughs' => 315,
            'setup' => 'Why are graveyards so noisy?',
            'punchline' => 'Because of all the coffin.'],
            ['laughs' => 316,
            'setup' => 'Why are mummys scared of vacation?',
            'punchline' => 'They\'re afraid to unwind.'],
            ['laughs' => 333,
            'setup' => 'Why did the Clydesdale give the pony a glass of water?',
            'punchline' => 'Because he was a little horse!'],
            ['laughs' => 120,
            'setup' => 'How do hens stay fit?',
            'punchline' => 'They always egg-cercise!']
        ];
        foreach($data as $d){
        // This will pre-populate some joke data into the database after the tabe has been created (after the up function has been called)
        $this->connection->insert('joke', $d);
        }

    }

    
}
