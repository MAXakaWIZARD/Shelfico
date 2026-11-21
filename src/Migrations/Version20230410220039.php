<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410220039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products ADD supplier_sale_price_uah NUMERIC(20, 2) NOT NULL COMMENT \'Supplier sale price, UAH\', CHANGE last_buy_price last_buy_price_uah NUMERIC(20, 2) NOT NULL COMMENT \'Last buy price, UAH\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP supplier_sale_price_uah, CHANGE last_buy_price_uah last_buy_price NUMERIC(20, 2) NOT NULL COMMENT \'Last buy price, UAH\'');
    }
}
