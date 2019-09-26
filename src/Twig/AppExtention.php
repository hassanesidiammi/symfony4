<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtention extends AbstractExtension implements GlobalsInterface
{
    public function getFilters()
    {
        return [
          new TwigFilter('price', [$this, 'FormatPriceNumber']),
        ];
    }

    public function FormatPriceNumber($number)
    {
        return '$'.number_format($number, 2, '.', ',');
    }

    /**
     * @inheritDoc
     */
    public function getGlobals()
    {
        return [
            'my_global_variable' => 'Hello, I am a global var!',
        ];
    }
}