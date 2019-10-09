<?php

declare(strict_types=1);

namespace App\Controller;


use Acl\Controller\Component\AclComponent;
use Acl\Model\Table\AcosTable;
use App\AclDependencies;
use App\Lib\Api\ApiPaginator;
use App\Model\Table\UsergroupsTable;
use Authentication\Controller\Component\AuthenticationComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Http\Exception\ConflictException;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Class UsergroupsController
 * @package App\Controller
 * @property AuthenticationComponent $Authentication
 */
class UsergroupsController extends AppController {

    public function index() {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        $UsergroupsTable = TableRegistry::getTableLocator()->get('Usergroups');

        $ApiPaginator = new ApiPaginator($this, $this->request);

        $entities = $UsergroupsTable->getUsergroupsIndex($ApiPaginator);

        $myself = $this->Authentication->getIdentity();


        $this->set('usergroups', $entities);
        $this->set('myself', $myself->get('usergroup_id'));
        $this->viewBuilder()->setOption('serialize', ['usergroups', 'myself']);
    }

    public function add() {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        /** @var AcosTable $AcosTable */
        $AcosTable = TableRegistry::getTableLocator()->get('Acl.Acos');

        if ($this->request->is('get') && $this->isJsonRequest()) {
            $acos = $AcosTable->find('threaded')->all();
            $this->set('acos', $acos);
            $this->viewBuilder()->setOption('serialize', ['acos']);
            return;
        }

        /** @var UsergroupsTable $UsergroupsTable */
        $UsergroupsTable = TableRegistry::getTableLocator()->get('Usergroups');

        $usergroup = $UsergroupsTable->newEmptyEntity();
        $usergroup = $UsergroupsTable->patchEntity($usergroup, $this->request->getData('Usergroup'));

        $UsergroupsTable->save($usergroup);
        if ($usergroup->hasErrors()) {
            //This throws the body content away :(
            $this->response = $this->response->withStatus(400);
            $this->set('error', $usergroup->getErrors());
            $this->viewBuilder()->setOption('serialize', ['error']);
            return;
        }

        //Save Acos
        $AclDependencies = new AclDependencies();
        $selectedAcos = $this->request->getData('Acos');
        $selectedAcos = $AclDependencies->getDependentAcos($AcosTable, $selectedAcos);

        $registry = new ComponentRegistry();
        $Acl = new AclComponent($registry);
        foreach ($selectedAcos as $acoId => $state) {
            if ($state === 1) {
                $Acl->allow($usergroup->get('id'), $acoId, '*');
            } else {
                $Acl->deny($usergroup->get('id'), $acoId, '*');
            }
        }

        $this->set('usergroup', $usergroup);
        $this->viewBuilder()->setOption('serialize', ['usergroup']);
    }

    public function edit($id = null) {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        /** @var UsergroupsTable $UsergroupsTable */
        $UsergroupsTable = TableRegistry::getTableLocator()->get('Usergroups');

        if (!$UsergroupsTable->existsById($id)) {
            throw new NotFoundException(__('User group not found'));
        }

        $usergroup = $UsergroupsTable->find()
            ->contain([
                'Aros' => [
                    'Acos'
                ]
            ])
            ->where([
                'Usergroups.id' => $id
            ])
            ->firstOrFail();

        /** @var AcosTable $AcosTable */
        $AcosTable = TableRegistry::getTableLocator()->get('Acl.Acos');

        if ($this->request->is('get')) {
            $acos = $AcosTable->find('threaded')->all();

            $this->set('usergroup', $usergroup);
            $this->set('acos', $acos);
            $this->viewBuilder()->setOption('serialize', ['usergroup', 'acos']);
            return;
        }

        if ($this->request->is('post')) {
            $usergroup->setAccess('id', false);
            $usergroup = $UsergroupsTable->patchEntity($usergroup, $this->request->getData());

            $UsergroupsTable->save($usergroup);
            if ($usergroup->hasErrors()) {
                $this->response = $this->response->withStatus(400);
                $this->set('error', $usergroup->getErrors());
                $this->viewBuilder()->setOption('serialize', ['error']);
                return;
            }

            //Save Acos
            $AclDependencies = new AclDependencies();
            $selectedAcos = $this->request->getData('Acos');
            $selectedAcos = $AclDependencies->getDependentAcos($AcosTable, $selectedAcos);

            $registry = new ComponentRegistry();
            $Acl = new AclComponent($registry);
            foreach ($selectedAcos as $acoId => $state) {
                if ($state === 1) {
                    $Acl->allow($usergroup->get('id'), $acoId, '*');
                } else {
                    $Acl->deny($usergroup->get('id'), $acoId, '*');
                }
            }

            $this->set('usergroup', $usergroup);
            $this->viewBuilder()->setOption('serialize', ['usergroup']);
        }
    }

    public function delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $id = $this->request->getData('id');

        /** @var UsergroupsTable $UsergroupsTable */
        $UsergroupsTable = TableRegistry::getTableLocator()->get('Usergroups');
        if (!$UsergroupsTable->existsById($id)) {
            throw new NotFoundException(__('User group not found'));
        }

        $myself = $this->Authentication->getIdentity();

        if ($id == $myself->get('usergroup_id')) {
            throw new ConflictException(__('You can not delete your own user group!'));
        }

        $usergroup = $UsergroupsTable->get($id);
        if ($UsergroupsTable->delete($usergroup)) {
            $this->set('success', true);
            $this->viewBuilder()->setOption('serialize', ['success']);
            return;
        }
        $this->response->statusCode(400);
        $this->set('success', false);
        $this->viewBuilder()->setOption('serialize', ['success']);
    }
}
