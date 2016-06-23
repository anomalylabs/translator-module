<?php namespace Anomaly\TranslatorModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

class TranslatorModule extends Module
{

    /**
     * The navigation icon.
     *
     * @var string
     */
    protected $icon = 'addon';

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = [
        'modules',
        'themes',
        'plugins',
        'extensions',
        'field_types',
        'system',
    ];

}
