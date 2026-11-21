<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Product;

class Warehouse
{
    protected Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }
    
    protected function getCommissionRatio(): float
    {
        return (100 + (int) $this->settings->get(Settings::PAYMENT_COMISSION_PERCENT)) / 100;
    }

    protected function getSupplierDiscountRatio(): float
    {
        return (100 - (int) $this->settings->get(Settings::SUPPLIER_DISCOUNT_PERCENT)) / 100;
    }

    public function calcBuyPrice(Product $product): float
    {
        return $product->getSupplierSalePrice()
            * $this->getSupplierDiscountRatio()
            * $this->getCommissionRatio()
            + (int) $this->settings->get(Settings::ITEM_DELIVERY_PRICE);
    }
    
    /**
     * @param Product[] $products
     */
    public function calcTotalBuyPrice(array $products): float
    {
        $price = 0;
        foreach ($products as $product) {
            $price += $product->getQuantity() * $this->calcBuyPrice($product);
        }

        return $price;
    }
    
    public function calcProfit(Product $product): float
    {
        return $product->getSalePrice() - $this->calcBuyPrice($product);
    }
}
