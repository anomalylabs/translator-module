<?php namespace Anomaly\TranslatorModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\TranslatorModule\Translation\Command\GetTranslationKeys;
use Anomaly\TranslatorModule\Translation\Form\TranslationFormBuilder;
use Illuminate\Contracts\Config\Repository;

/**
 * Class TranslationsController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Http\Controller\Admin
 */
class TranslationsController extends PublicController
{

    /**
     * Show translations for an addon.
     *
     * @param AddonCollection $addons
     * @param Repository      $config
     * @param                 $namespace
     * @return \Illuminate\Contracts\View\View|mixed|object
     */
    public function translations(AddonCollection $addons, Repository $config, $namespace)
    {
        $addon = $addons->get($namespace);

        $missing = [];

        $en = $this->dispatch(new GetTranslationKeys($addon, 'en'));

        foreach ($config->get('streams::locales.enabled') as $locale) {

            if ($locale == 'en') {
                continue;
            }

            $keys = $this->dispatch(new GetTranslationKeys($addon, $locale));

            $differences = array_diff_key(
                array_dot($en),
                array_dot($keys)
            );

            foreach ($differences as $key => $difference) {

                $file = substr($key, 0, strpos($key, '.php') + 4);

                $missing[$locale][$file][] = str_replace($file . '.', '', $key);
            }
        }

        return $this->view->make('module::translations/translations', compact('addon', 'missing'));
    }

    /**
     * Display the differences in translations.
     *
     * @param AddonCollection $addons
     * @param                 $namespace
     * @param                 $locale
     * @return \Illuminate\Contracts\View\View|mixed|object
     */
    public function differences(AddonCollection $addons, $namespace, $locale)
    {
        $addon = $addons->get($namespace);

        $missing = [];

        $en = $this->dispatch(new GetTranslationKeys($addon, 'en'));

        $keys = $this->dispatch(new GetTranslationKeys($addon, $locale));

        $differences = array_diff_key(
            array_dot($en),
            array_dot($keys)
        );

        foreach ($differences as $key => $difference) {

            $file = substr($key, 0, strpos($key, '.php') + 4);

            $missing[$file][] = str_replace($file . '.', '', $key);
        }

        return $this->view->make('module::translations/differences', compact('addon', 'missing'));
    }

    /**
     * Translate an addon.
     *
     * @param TranslationFormBuilder $form
     * @param                        $namespace
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function translate(TranslationFormBuilder $form, $namespace)
    {
        return $form
            ->setEntry($namespace)
            ->render();
    }
}
