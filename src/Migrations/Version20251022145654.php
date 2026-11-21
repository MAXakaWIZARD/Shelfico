<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251022145654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP exchange_rate');
        $this->addSql('ALTER TABLE products DROP buy_price_usd, DROP sale_price_usd');
        $this->addSql('ALTER TABLE restocks DROP exchange_rate');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD exchange_rate NUMERIC(20, 2) NOT NULL');
        $this->addSql('ALTER TABLE products ADD buy_price_usd NUMERIC(20, 2) NOT NULL COMMENT \'Buy price, USD\', ADD sale_price_usd NUMERIC(20, 2) NOT NULL COMMENT \'Sale price, USD\'');
        $this->addSql('ALTER TABLE restocks ADD exchange_rate NUMERIC(20, 2) NOT NULL');
    }
}
