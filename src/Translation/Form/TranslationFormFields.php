<?php namespace Anomaly\TranslatorModule\Translation\Form;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\TranslatorModule\Translation\Command\GetTranslationKeys;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class TranslationFormFields
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Translation\Form
 */
class TranslationFormFields
{

    use DispatchesJobs;

    /**
     * Handle the fields.
     *
     * @param TranslationFormBuilder $builder
     * @param AddonCollection        $addons
     * @param Repository             $config
     */
    public function handle(TranslationFormBuilder $builder, AddonCollection $addons, Repository $config)
    {
        $fields = [];

        $addon = $addons->get($entry = $builder->getEntry());

        $base = $this->dispatch(new GetTranslationKeys($addon, 'en'));

        $translations = [];

        foreach ($config->get('streams::locales.enabled') as $locale) {

            $translation = $this->dispatch(new GetTranslationKeys($addon, $locale));

            foreach ($translation as $file => &$keys) {

                $keys = array_dot($keys);

                foreach ($keys as $key => $value) {
                    $translations[$file][$key][$locale] = $value;
                }
            }
        }

        foreach ($base as $file => $keys) {

            foreach (array_dot($keys) as $key => $value) {

                $fields[basename($file, '.php') . '.' . $key] = [
                    'label'        => $key,
                    'translatable' => true,
                    'instructions' => '<strong>' . $value . '</strong>',
                    'config'       => [
                        'file' => $file,
                        'max'  => 999,
                    ],
                    'values'       => $translations[$file][$key],
                    'type'         => 'anomaly.field_type.text'
                ];
            }
        }

        $builder->setFields($fields);
    }
}
