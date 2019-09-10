<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class MeasurementsController extends AppController {

    public function index() {

        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        $MeasurementsTable = TableRegistry::getTableLocator()->get('Measurements');
        $entities = $MeasurementsTable->find()->all();
        $this->set('measurements', $entities);

        $this->viewBuilder()->setOption('serialize', ['measurements']);

        //$this->loadComponent('Paginator');
        //$measurements = $this->Paginator->paginate($this->Measurements->find());
        //$this->set(compact('measurements'));
    }

    public function add() {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        $MeasurementsTable = TableRegistry::getTableLocator()->get('Measurements');
        $entity = $MeasurementsTable->newEntity($this->request->getData());

        $MeasurementsTable->save($entity);
        if ($entity->hasErrors()) {
            //This throws the body content away :(
            $this->response = $this->response->withStatus(400);
            $this->set('error', $entity->getErrors());
            $this->viewBuilder()->setOption('serialize', ['error']);
            return;
        }
        $this->set('measurement', $entity);
        $this->viewBuilder()->setOption('serialize', ['measurement']);
    }

}
