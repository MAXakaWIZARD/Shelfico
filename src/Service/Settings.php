<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class Settings
{
    public const string ITEM_DELIVERY_PRICE = 'ITEM_DELIVERY_PRICE';
    public const string PAYMENT_COMISSION_PERCENT = 'PAYMENT_COMISSION_PERCENT';
    public const string SUPPLIER_DISCOUNT_PERCENT = 'SUPPLIER_DISCOUNT_PERCENT';
    public const string CURRENCY_CODE3 = 'CURRENCY_CODE3';
    public const string CURRENCY_SYMBOL = 'CURRENCY_SYMBOL';
    public const string CURRENCY_ICON_CLASS = 'CURRENCY_ICON_CLASS';
    
    protected array $defaultValues = [
        self::ITEM_DELIVERY_PRICE => 0,        
        self::PAYMENT_COMISSION_PERCENT => 0,        
        self::SUPPLIER_DISCOUNT_PERCENT => 20,
        self::CURRENCY_CODE3 => 'USD',
        self::CURRENCY_SYMBOL => '$',
        self::CURRENCY_ICON_CLASS => 'fa-dollar-sign',
    ];

    protected EntityManagerInterface $em;

    /** @var Setting[] */
    protected array $settings = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    protected function load(): void
    {
        try {
            $settingsRepo = $this->em->getRepository(Setting::class);

            $settings = $settingsRepo->findAll();
            foreach ($settings as $setting) {
                $this->settings[$setting->getName()] = $setting->getTypedValue();
            }
        } catch (Exception) {
            //nothing here
        }
    }

    public function get(string $name, mixed $defaultValue = null): mixed
    {
        if (!count($this->settings)) {
            $this->load();
        }

        if (isset($this->settings[$name])) {
            return $this->settings[$name];
        } elseif (!is_null($defaultValue)) {
            return $defaultValue;
        } elseif (isset($this->defaultValues[$name])) {
            return $this->defaultValues[$name];
        }

        throw new Exception('Setting not found and no fallback value provided: ' . $name);
    }
}
