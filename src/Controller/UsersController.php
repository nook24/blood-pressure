<?php
declare(strict_types=1);

namespace App\Controller;


use App\Model\Table\UsersTable;
use Authentication\Authenticator\ResultInterface;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;

/**
 * Class UsersController
 * @package App\Controller
 * @property AuthenticationComponent $Authentication
 */
class UsersController extends AppController {

    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function login() {
        $this->viewBuilder()->setLayout('login');

        if ($this->request->is('get')) {
            $this->set('_csrfToken', $this->request->getParam('_csrfToken'));
            $this->viewBuilder()->setOption('serialize', ['_csrfToken']);
            return;
        }

        /** @var UsersTable $UsersTable */
        $UsersTable = TableRegistry::getTableLocator()->get('Users');

        if ($this->request->is('post')) {
            $user = $UsersTable->newEntity($this->request->getData());
            $this->set('user', $user);

            $result = $this->Authentication->getResult();
            if ($result->getStatus() === ResultInterface::SUCCESS) {
                $this->set('success', true);
                $this->viewBuilder()->setOption('serialize', ['success']);
                return;
            }

            $this->response = $this->response->withStatus(400);
            $this->set('success', false);
            $this->viewBuilder()->setOption('serialize', ['success']);
        }
    }

    public function logout() {
        $this->Authentication->logout();
        $this->redirect([
            'action' => 'login'
        ]);
    }

    public function add() {
        if($this->isHtmlRequest()){
            //Only ship html template
            return;
        }

        /** @var UsersTable $UsersTable */
        $UsersTable = TableRegistry::getTableLocator()->get('Users');

        $user = $UsersTable->newEmptyEntity();
        $user = $UsersTable->patchEntity($user, $this->request->getData());

        $UsersTable->save($user);
        if ($user->hasErrors()) {
            //This throws the body content away :(
            $this->response = $this->response->withStatus(400);
            $this->set('error', $user->getErrors());
            $this->viewBuilder()->setOption('serialize', ['error']);
            return;
        }
        $this->set('user', $user);
        $this->viewBuilder()->setOption('serialize', ['user']);
    }
}
