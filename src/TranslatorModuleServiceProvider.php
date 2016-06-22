<?php namespace Anomaly\TranslatorModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class TranslatorModuleServiceProvider
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule
 */
class TranslatorModuleServiceProvider extends AddonServiceProvider
{

    /**
     * The addon routes.
     *
     * @var array
     */
    protected $routes = [
        'admin/translator/{type?}'                          => 'Anomaly\TranslatorModule\Http\Controller\Admin\AddonsController@index',
        'admin/translator/translations/{namespace}'         => 'Anomaly\TranslatorModule\Http\Controller\Admin\TranslationsController@translations',
        'admin/translator/differences/{namespace}/{locale}' => 'Anomaly\TranslatorModule\Http\Controller\Admin\TranslationsController@differences',
        'admin/translator/translate/{namespace}'            => 'Anomaly\TranslatorModule\Http\Controller\Admin\TranslationsController@translate',
    ];
}
