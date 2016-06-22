<?php namespace Anomaly\TranslatorModule\Translation\Form;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class TranslationFormSections
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Translation\Form
 */
class TranslationFormSections
{

    use DispatchesJobs;

    /**
     * Handle the sections.
     *
     * @param TranslationFormBuilder $builder
     */
    public function handle(TranslationFormBuilder $builder)
    {
        $sections = [];

        foreach ($builder->getFields() as $field) {

            if (!isset($sections[$file = array_get($field, 'config.file')])) {
                $sections[$file] = [
                    'title'   => $file,
                    'context' => 'info',
                ];
            }

            $sections[$file]['fields'][] = $field['field'];
        }

        $builder->setSections($sections);
    }
}
