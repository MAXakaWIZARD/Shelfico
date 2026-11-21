<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Extra\HasRatingInterface;
use App\Service\Settings;
use App\Service\Warehouse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractForm extends AbstractType implements FormTypeInterface
{
    protected UrlGeneratorInterface $urlGenerator;
    protected EntityManagerInterface $em;
    protected Settings $settings;
    protected Warehouse $warehouse;

    public function __construct(
        UrlGeneratorInterface $urlGenerator, 
        EntityManagerInterface $em,
        Settings $settings,
        Warehouse $warehouse
    ) {
        $this->urlGenerator = $urlGenerator;
        $this->em = $em;
        $this->settings = $settings;
        $this->warehouse = $warehouse;
    }

    public function getRatingChoices(): array
    {
        $ratingChoices = [
            '?' => 0,
        ];
        for ($i = 1; $i <= HasRatingInterface::MAX_RATING; $i++) {
            $ratingChoices[$i] = $i;
        }

        return $ratingChoices;
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
