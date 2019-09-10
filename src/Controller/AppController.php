<?php
declare(strict_types=1);

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
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     * @throws \Exception
     *
     */
    public function initialize(): void {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication', [
            'logoutRedirect' => '/users/login'  // Default is false
        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    /**
     * @return bool
     */
    protected function isHtmlRequest(): bool {
        return $this->request->getParam('_ext') === 'html';
    }

    /**
     * @return bool
     */
    protected function isJsonRequest(): bool {
        return $this->request->getParam('_ext') === 'json';
    }

    /**
     * Add CSRF token to all .json requests
     */
    public function beforeRender(EventInterface $event) {
        if ($this->isJsonRequest()) {
            $this->set('_csrfToken', $this->request->getParam('_csrfToken'));

            $serialize = $this->viewBuilder()->getOption('serialize');
            if ($serialize === null) {
                $serialize = [];
            }
            $serialize[] = '_csrfToken';

            //Add Paginator info to json response
            $paging = $this->viewBuilder()->getVar('paging');
            if($paging !== null){
                $serialize[] = 'paging';
            }

            $this->viewBuilder()->setOption('serialize', $serialize);
        }
    }
}
