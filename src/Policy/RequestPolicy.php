<?php

namespace App\Policy;


use Acl\Controller\Component\AclComponent;
use Acl\Model\Table\ArosTable;
use Authorization\Policy\RequestPolicyInterface;
use Cake\Controller\ComponentRegistry;
use Cake\Controller\Exception\SecurityException;
use Cake\Http\ServerRequest;
use Cake\ORM\TableRegistry;

class RequestPolicy implements RequestPolicyInterface {

    /**
     * Method to check if the request can be accessed
     *
     * @param \Authorization\IdentityInterface|null Identity
     * @param \Cake\Http\ServerRequest $request Server Request
     * @return bool
     */
    public function canAccess($identity, ServerRequest $request) {
        //debug($identity);die();
        $controller = $request->getParam('controller');
        $action = $request->getParam('action');
        $plugin = $request->getParam('plugin');

        $Collection = new ComponentRegistry();
        $Acl = new AclComponent($Collection);

        /** @var ArosTable $ArosTable */
        $ArosTable = TableRegistry::getTableLocator()->get('Acl.Aros');

        $usergroupId = $identity->get('usergroup_id');

        $usergroupHasAros = $ArosTable->exists([
            'Aros.foreign_key' => $usergroupId
        ]);

        if ($usergroupHasAros === false) {
            throw new SecurityException('No Aros defined for given usergroup_id!');
        }

        // Uncomment to disable ACL permission checks
        return true;

        //debug($Acl->check(['Usergroups' => ['id' => $usergroupId]], "$controller/$action"));die();
        return $Acl->check(['Usergroups' => ['id' => $usergroupId]], "$controller/$action");
    }
}
