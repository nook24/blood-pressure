<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Lib\Api\ApiPaginator;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Exception\NotFoundException;

class MeasurementsController extends AppController
{

    public function index()
    {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        $user = $this->Authentication->getIdentity();

        $MeasurementsTable = TableRegistry::getTableLocator()->get('Measurements');

        $ApiPaginator = new ApiPaginator($this, $this->request);

        $entities = $MeasurementsTable->getMeasurementsIndex($ApiPaginator, $user->get('id'));
        $this->set('measurements', $entities);

        $this->viewBuilder()->setOption('serialize', ['measurements']);
    }

    public function add()
    {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        $user = $this->Authentication->getIdentity();

        $MeasurementsTable = TableRegistry::getTableLocator()->get('Measurements');
        $entity = $MeasurementsTable->newEntity($this->request->getData());
        $entity->set('user_id', $user->get('id'));

        $MeasurementsTable->save($entity);
        if ($entity->hasErrors()) {
            $this->response = $this->response->withStatus(400);
            $this->set('error', $entity->getErrors());
            $this->viewBuilder()->setOption('serialize', ['error']);
            return;
        }
        $this->set('measurement', $entity);
        $this->viewBuilder()->setOption('serialize', ['measurement']);
    }


    public function edit($id = null)
    {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        $user = $this->Authentication->getIdentity();

        $MeasurementsTable = TableRegistry::getTableLocator()->get('Measurements');

        if (!$MeasurementsTable->existsByIdAndUserId($id, $user->get('id'))) {
            throw new NotFoundException(__('Measurement not found'));
        }

        $measurement = $MeasurementsTable->get($id);

        if ($this->request->is('get')) {
            $this->set('measurement', $measurement);
            $this->viewBuilder()->setOption('serialize', ['measurement']);
            return;
        }

        if ($this->request->is('post')) {
            $measurement->setAccess('id', false);
            $measurement->setAccess('user_id', false);
            $measurement = $MeasurementsTable->patchEntity($measurement, $this->request->getData());

            $MeasurementsTable->save($measurement);
            if ($measurement->hasErrors()) {
                $this->response = $this->response->withStatus(400);
                $this->set('error', $measurement->getErrors());
                $this->viewBuilder()->setOption('serialize', ['error']);
                return;
            }
            $this->set('measurement', $measurement);
            $this->viewBuilder()->setOption('serialize', ['measurement']);
        }
    }


    public function delete()
    {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }

        $id = $this->request->getData('id');

        $MeasurementsTable = TableRegistry::getTableLocator()->get('Measurements');
        if (!$MeasurementsTable->existsById($id)) {
            throw new NotFoundException(__('Measurement not found'));
        }
        $measurement = $MeasurementsTable->get($id);
        if ($MeasurementsTable->delete($measurement)) {
            $this->set('success', true);
            $this->viewBuilder()->setOption('serialize', ['success']);
            return;
        }
        $this->response->statusCode(400);
        $this->set('success', false);
        $this->viewBuilder()->setOption('serialize', ['success']);
    }
}
