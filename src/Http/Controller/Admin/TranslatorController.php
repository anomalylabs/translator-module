<?php namespace Anomaly\TranslatorModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;

/**
 * Class TranslatorController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\TranslatorModule\Http\Controller\Admin
 */
class TranslatorController extends AdminController
{

    public function instructions()
    {
        return $this->view->make('module::instructions');
    }
}
