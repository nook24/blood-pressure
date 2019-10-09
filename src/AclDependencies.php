<?php

namespace App;

use Acl\Model\Table\AcosTable;

/**
 * Class AclDependencies
 * @package App
 */
class AclDependencies {

    /**
     * Hold a list of controllers and actions which
     * should always be allowed and could not be disabled by the user
     *
     * For Example:
     * PagesController::paginator()
     * PagesController::csrf()
     * Users::login()
     * Users::logout()
     *
     * @var array
     */
    private $allow = [];

    /**
     * Controller actions that depends on other controller actions.
     * This often happens when using a lot of Ajax in your frontend.
     *
     * For example:
     * Users::edit() make an Ajax call to Users::loadUsergroups() etc...
     *
     * @var array
     */
    private $dependencies = [];

    /**
     * AclDependencies constructor.
     */
    public function __construct() {
        // Add actions that should always be allowed.
        $this
            ->allow('Pages', 'index')
            ->allow('Pages', 'paginator')
            ->allow('Pages', 'error403')
            ->allow('Pages', 'csrf')
            ->allow('Users', 'login')
            ->allow('Users', 'logout');


        // Add dependencies
        $this->dependency('Users', 'edit', 'Users', 'loadUsergroups');
    }

    /**
     * @param string $controller
     * @param string $action
     * @return $this
     */
    public function allow(string $controller, string $action): self {
        if (!isset($this->allow[$controller])) {
            $this->allow[$controller] = [];
        }

        $this->allow[$controller][] = $action;
        return $this;
    }

    /**
     * @param string $controller
     * @param string $action
     * @param string $dependentController
     * @param $dependentAction
     * @return $this
     */
    public function dependency(string $controller, string $action, string $dependentController, $dependentAction): self {
        if (!isset($this->dependencies[$controller][$action])) {
            $this->dependencies[$controller][$action] = [];
        }

        if (!isset($this->dependencies[$controller][$action][$dependentController])) {
            $this->dependencies[$controller][$action][$dependentController] = [];
        }

        $this->dependencies[$controller][$action][$dependentController][] = $dependentAction;


        return $this;
    }

    /**
     * @param AcosTable $AcosTable
     * @param array $selectedAcos
     * @return array
     */
    public function getDependentAcos(AcosTable $AcosTable, array $selectedAcos): array {
        $threadedAcos = $AcosTable->find('threaded')
            ->disableHydration()
            ->all();

        $acos = [];
        foreach ($threadedAcos as $threadedAco) {
            foreach ($threadedAco['children'] as $controllerAcos) {
                $acos[$controllerAcos['alias']] = [
                    'id'      => $controllerAcos['id'],
                    'actions' => []
                ];
                foreach ($controllerAcos['children'] as $actionAco) {
                    $acos[$controllerAcos['alias']]['actions'][$actionAco['alias']] = [
                        'id' => $actionAco['id'],
                    ];
                }
            }
        }

        //Add always allowed ACL actions to $selectedAcos
        foreach ($this->allow as $controller => $actions) {
            foreach ($actions as $action) {
                if (isset($acos[$controller]['actions'][$action]['id'])) {
                    $acoId = $acos[$controller]['actions'][$action]['id'];

                    $selectedAcos[$acoId] = 1;
                }
            }
        }

        //Build up dependency tree (dependent ACL actions)
        $dependencyTree = [];
        foreach ($this->dependencies as $controller => $actions) {
            foreach ($actions as $action => $dependentControllers) {
                foreach ($dependentControllers as $dependentController => $dependentActions) {
                    foreach ($dependentActions as $dependentAction) {
                        //debug(sprintf(
                        //    '%s/%s depends on %s/%s',
                        //    $controller,
                        //    $action,
                        //    $dependentController,
                        //    $dependentAction
                        //));

                        if (isset($acos[$controller]['actions'][$action]['id'])) {
                            if (isset($acos[$dependentController]['actions'][$dependentAction]['id'])) {
                                $acoId = $acos[$controller]['actions'][$action]['id'];
                                $dependentAcoId = $acos[$dependentController]['actions'][$dependentAction]['id'];

                                $dependencyTree[$acoId][] = $dependentAcoId;
                            }
                        }
                    }
                }
            }
        }

        //Add dependent ACL actions to $selectedAcos
        foreach ($selectedAcos as $acoId => $permissions) {
            if ($permissions === 1) {
                if (isset($dependencyTree[$acoId])) {
                    //Add dependencies to $selectedAcos;

                    foreach ($dependencyTree[$acoId] as $dependentAcoId) {
                        $selectedAcos[$dependentAcoId] = 1;
                    }
                }
            }
        }

        return $selectedAcos;
    }

}

