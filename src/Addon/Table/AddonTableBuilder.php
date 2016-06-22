<?php namespace Anomaly\TranslatorModule\Addon\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class AddonTableBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Addon\Table
 */
class AddonTableBuilder extends TableBuilder
{

    /**
     * The addon type to list.
     *
     * @var null|string
     */
    protected $type = null;

    /**
     * The table buttons.
     *
     * @var array
     */
    protected $buttons = [
        'translate'  => [
            'type' => 'success',
            'icon' => 'translate',
            'href' => 'admin/translator/translate/{entry.namespace}',
        ],
        'difference' => [
            'type'        => 'info',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            'icon'        => 'fa fa-exclamation',
            'href'        => 'admin/translator/translations/{entry.namespace}',
        ],
    ];

    /**
     * Get the type.
     *
     * @return null|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type.
     *
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
