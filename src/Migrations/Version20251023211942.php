<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023211942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags CHANGE color color ENUM(\'primary\', \'default\', \'success\', \'info\', \'warning\', \'danger\') NULL DEFAULT \'default\' COMMENT \'(DC2Type:labelclass)\'');
        $this->addSql('UPDATE tags SET color=NULL WHERE color=\'default\'');
        $this->addSql('ALTER TABLE tags CHANGE color color ENUM(\'primary\', \'secondary\', \'success\', \'info\', \'warning\', \'danger\', \'light\', \'dark\') NULL DEFAULT \'secondary\' COMMENT \'(DC2Type:labelclass)\'');
        $this->addSql('UPDATE tags SET color=\'secondary\' WHERE color IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tags CHANGE color color ENUM(\'primary\', \'default\', \'success\', \'info\', \'warning\', \'danger\') NULL DEFAULT \'default\' NOT NULL COMMENT \'(DC2Type:labelclass)\'');
    }
}
