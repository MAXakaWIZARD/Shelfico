<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Product;
use App\Entity\Tag;
use App\Service\Settings;
use App\Service\Warehouse;
use App\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Process\Process;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private EntityManagerInterface $em;
    private array $tags = [];
    private ParameterBagInterface $parameterBag;
    private Settings $settings;
    private Warehouse $warehouse;

    public function __construct(
        EntityManagerInterface $em,
        ParameterBagInterface $parameterBag,
        Settings $settings,
        Warehouse $warehouse
    ) {
        $this->em = $em;
        $this->parameterBag = $parameterBag;
        $this->settings = $settings;
        $this->warehouse = $warehouse;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'get_tags',
                [$this, 'getTags'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'get_parameter',
                [$this, 'getParameter'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'get_product_photo_url',
                [$this, 'getProductPhotoUrl'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'process_output',
                function (Process $process) {
                    return Utils::getHtmlFriendlyProcessOutput($process);
                },
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'get_setting',
                [$this, 'getSetting'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'calc_profit',
                [$this, 'calcProfit'],
                ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'calc_buy_price',
                [$this, 'calcBuyPrice'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('dechex', 'dechex'),
            new TwigFilter('assetize', [$this, 'assetize']),
            new TwigFilter('format_price', [$this, 'formatPrice']),
        ];
    }

    public function assetize($url): string
    {
        if ($url) {
            return $url . '?v=' . time();
        }

        return '';
    }

    public function formatPrice($content): string
    {
        return number_format((float) $content, 0, '.', ' ');
    }

    /**
     * @return mixed
     */
    public function getParameter(string $paramName)
    {
        return $this->parameterBag->get($paramName);
    }


    public function getTags(): array
    {
        if (!is_null($this->tags)) {
            return $this->tags;
        }

        $this->tags = $this->em->getRepository(Tag::class)->findBy([], ['title' => 'ASC']);

        return $this->tags;
    }

    public function getProductPhotoUrl(Product $product): ?string
    {
        if ($product->hasPhoto()) {
            return PRODUCT_IMAGES_SUBDIR . $product->getPhotoPath();
        }

        return null;
    }
    
    public function getSetting(string $name, mixed $defaultValue = null): mixed
    {
        return $this->settings->get($name, $defaultValue);
    }
    
    public function calcProfit(Product $product): float
    {
        return $this->warehouse->calcProfit($product);
    }
    
    public function calcBuyPrice(Product $product): float
    {
        return $this->warehouse->calcBuyPrice($product);
    }

    public function getName(): string
    {
        return 'app_extension';
    }
}
