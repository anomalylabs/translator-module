<?php namespace Anomaly\TranslatorModule\Translation\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class TranslationFormBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Translation\Form
 */
class TranslationFormBuilder extends FormBuilder
{

    /**
     * Headless form.
     *
     * @var bool
     */
    protected $model = false;

    public function onBuilt()
    {
        $fields = $this->getFormFields();

        foreach ($fields as $field) {
            if ($field->getLocale() == 'en') {
                $field->setDisabled(true);
            }
        }
    }
}
