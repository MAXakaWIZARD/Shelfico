<?php

declare(strict_types=1);

namespace App\EventListener;

use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class AppListener implements EventSubscriberInterface
{
    private ParameterBagInterface $parameterBag;

    public function __construct(
        ParameterBagInterface $parameterBag
    ) {
        $this->parameterBag = $parameterBag;
    }

    protected function defineConstants()
    {
        if (defined('BASE_PATH')) {
            return;
        }

        define('IS_WINDOWS', strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
        define('BASE_PATH', realpath($this->parameterBag->get('kernel.project_dir')));

        define('PRODUCT_IMAGES_PATH', $this->parameterBag->get('paths.product_images'));
        define('PRODUCT_IMAGES_SUBDIR', $this->parameterBag->get('product_images_subdir'));
    }

    public function onRequest()
    {
        $this->defineConstants();
    }

    public function onCommand()
    {
        $this->defineConstants();
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onRequest'],
            ConsoleEvents::COMMAND => ['onCommand'],
        ];
    }
}
