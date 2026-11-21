<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261121170327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE
              orders
            CHANGE
              price price NUMERIC(20, 2) NOT NULL COMMENT 'Price',
            CHANGE
              profit profit NUMERIC(20, 2) NOT NULL COMMENT 'Profit'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              products
            CHANGE
              last_buy_price_uah last_buy_price NUMERIC(20, 2) NOT NULL COMMENT 'Last buy price',
            CHANGE
              supplier_sale_price_uah supplier_sale_price NUMERIC(20, 2) NOT NULL COMMENT 'Supplier sale price'
        SQL);
        $this->addSql('ALTER TABLE restocks CHANGE price price NUMERIC(20, 2) NOT NULL COMMENT \'Price\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE
              orders
            CHANGE
              price price NUMERIC(20, 2) NOT NULL COMMENT 'Price, UAH',
            CHANGE
              profit profit NUMERIC(20, 2) NOT NULL COMMENT 'Profit, UAH'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              products
            CHANGE
              last_buy_price last_buy_price_uah NUMERIC(20, 2) NOT NULL COMMENT 'Last buy price, UAH',
            CHANGE
              supplier_sale_price supplier_sale_price_uah NUMERIC(20, 2) NOT NULL COMMENT 'Supplier sale price, UAH'
        SQL);
        $this->addSql('ALTER TABLE restocks CHANGE price price NUMERIC(20, 2) NOT NULL COMMENT \'Price, UAH\'');
    }
}
