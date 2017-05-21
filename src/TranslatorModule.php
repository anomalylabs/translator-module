<?php namespace Anomaly\TranslatorModule;

use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class TranslatorModule
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TranslatorModule extends Module
{

    /**
     * The navigation icon.
     *
     * @var string
     */
    protected $icon = 'fa fa-language';

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
