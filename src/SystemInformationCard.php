<?php

namespace NovaCards\SystemInformationCard;

use Laravel\Nova\Card;

class SystemInformationCard extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'SystemInformationCard';
    }

    public function __construct(?string $name = null, ?string $component = null)
    {
        parent::__construct($component);
        $this->withMeta(['name' => $name ?? 'Hardware Statistic']);
    }


    public function name(string $name)
    {
        return $this->withMeta(['name' => $name]);
    }
}
