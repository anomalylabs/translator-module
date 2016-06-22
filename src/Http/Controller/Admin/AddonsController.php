<?php namespace Anomaly\TranslatorModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\TranslatorModule\Addon\Table\AddonTableBuilder;

/**
 * Class AddonsController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Http\Controller\Admin
 */
class AddonsController extends AdminController
{

    /**
     * Return a table of addons.
     *
     * @param AddonTableBuilder $table
     * @param                   $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(AddonTableBuilder $table, $type = 'modules')
    {
        if ($type == 'system') {
            return $this->redirect->to('admin/translator/translate/system');
        }

        return $table
            ->setType($type)
            ->render();
    }
}
