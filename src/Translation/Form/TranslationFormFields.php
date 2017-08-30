<?php namespace Anomaly\TranslatorModule\Translation\Form;

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
     * @param Repository             $config
     */
    public function handle(TranslationFormBuilder $builder, Repository $config)
    {
        $fields = [];

        $base = $this->dispatch(new GetTranslationKeys($entry = $builder->getEntry(), 'en'));

        $translations = [];

        foreach ($config->get('streams::locales.enabled') as $locale) {

            $translation = $this->dispatch(new GetTranslationKeys($entry, $locale));

            foreach ($translation as $file => &$keys) {

                $keys = array_dot($keys);

                foreach ($keys as $key => $value) {
                    
                    if(is_string($value)) {
                        $translations[$file][$key][$locale] = html_entity_decode($value, ENT_QUOTES);
                    }
                    
                }
            }
        }

        foreach ($base as $file => $keys) {

            foreach (array_dot($keys) as $key => $value) {

                $parts = explode('.', $key);

                $value = is_array($value) ? implode(' ', $value) : $value;

                $fields[basename($file, '.php') . '_' . $key] = [
                    'label'        => ucwords(str_replace('_', ' ', implode(' > ', $parts))),
                    'translatable' => true,
                    'instructions' => 'Translate: <strong>' . $value . '</strong>',
                    'config'       => [
                        'file' => $file,
                        'max'  => 999,
                    ],
                    'values'       =>  array_get(array_get($translations, $file), $key),
                    'type'         => 'anomaly.field_type.textarea',
                ];
            }
        }

        $builder->setFields($fields);
    }
}
