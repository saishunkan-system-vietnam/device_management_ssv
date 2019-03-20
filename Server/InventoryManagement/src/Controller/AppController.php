<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    const PAGE = 1;
    const PERPAGE = 10;

    public $payload = '';

    public $page;

    public $perpage;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->payload = [
            'status' => 'sucsess',
        ];

        if ($this->getRequest()->getQuery('perpage') != null) {
            $this->perpage = $this->getRequest()->getQuery('perpage');
        } elseif ($this->getRequest()->getData('perpage') != null) {
            $this->perpage = $this->getRequest()->getData('perpage');
        } else {
            $this->perpage = self::PERPAGE;
        }

        if ($this->getRequest()->getQuery('page') != null) {
            $this->page = $this->getRequest()->getQuery('page');
        } elseif ($this->getRequest()->getData('page') != null) {
            $this->page = $this->getRequest()->getData('page');
        } else {
            $this->page = self::PAGE;
        }

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        //$this->loadComponent('Csrf');
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     * beforeRender callback
     *
     * @return void
     */
    public function beforeRender(Event $event)
    {

        parent::beforeRender($event);

        $this->viewBuilder()->setLayout('api_respon');

        $this->set('response', $this->payload);

    }

    public function responseApi($status = 'success', $data_name = 'data', $data = null, $count = null)
    {
        $this->payload = [
            'status' => $status,
            'payload' => [
                $data_name => $data,
                'record_all' => $count
            ],
        ];

        $body = $this->response->getBody();
        $body->write(json_encode($this->payload));
        return $this->response->withBody($body);

    }

}
