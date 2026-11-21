<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251129171116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settings CHANGE type type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tags CHANGE color color VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE settings CHANGE type type ENUM(\'string\', \'int\', \'float\') DEFAULT \'string\' NOT NULL COMMENT \'(DC2Type:valuetype)\'');
        $this->addSql('ALTER TABLE tags CHANGE color color ENUM(\'primary\', \'secondary\', \'success\', \'info\', \'warning\', \'danger\', \'light\', \'dark\') DEFAULT \'secondary\' COMMENT \'(DC2Type:labelclass)\'');
    }
}
