<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250319230037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO tags (title,canonical) VALUES ('Announcement', 'announcement')");
        $this->addSql("INSERT INTO tags (title,canonical) VALUES ('Important', 'important')");
        $this->addSql("INSERT INTO tags (title,canonical) VALUES ('Spoiler', 'spoiler')");
        $this->addSql("INSERT INTO tags (title,canonical) VALUES ('NSFW', 'nsfw')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
