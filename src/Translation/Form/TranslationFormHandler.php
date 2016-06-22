<?php namespace Anomaly\TranslatorModule\Translation\Form;

/**
 * Class TranslationFormHandler
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Translation\Form
 */
class TranslationFormHandler
{

    /**
     * Handle the form.
     *
     * @param TranslationFormBuilder $builder
     */
    public function handle(TranslationFormBuilder $builder)
    {
        dd($builder->getFormFields());
    }
}
