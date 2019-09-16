<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use App\Lib\Api\ApiPaginator;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Exception\NotFoundException;

class DashboardsController extends AppController
{

    public function index()
    {
        if ($this->isHtmlRequest()) {
            //Only ship html template
            return;
        }

        $user = $this->Authentication->getIdentity();

        $MeasurementsTable = TableRegistry::getTableLocator()->get('Measurements');

        $start = (int) $this->request->getQuery('start');
        $end = (int) $this->request->getQuery('end');
        if (!is_numeric($start) || $start < 10000) {
            $start = time();
        }

        if (!is_numeric($end) || $end < 10000) {
            $end = time() - (3600 * 24 * 31);
        }

        $entities = $MeasurementsTable->getMeasurementsDashboard($start, $end, $user->get('id'));

        $chartData = [
            'labels' => [],
            'systolic' => [],
            'diastolic' => []
        ];

        //Calendar data
        $events = [];
        foreach ($entities as $entity) {
            $chartData['labels'][] = $entity->get('created')->format('d.m.Y');
            $chartData['systolic'][] = $entity->get('systolic');
            $chartData['diastolic'][] = $entity->get('diastolic');

            $classes = ['bg-success', 'border-success', 'text-white'];
            if ($entity->get('systolic') >= 130 && $entity->get('diastolic') >= 80) {
                $classes = ['bg-warning', 'border-warning', 'text-white'];
            }
            if ($entity->get('systolic') >= 140 && $entity->get('diastolic') >= 90) {
                $classes = ['bg-danger', 'border-danger', 'text-white'];
            }

            $events[] = [
                'id' => $entity->get('id'),
                'title' => sprintf(
                    '%s/%s/%s',
                    $entity->get('systolic'),
                    $entity->get('diastolic'),
                    $entity->get('heart_rate')
                ),
                'start' => gmdate('Y-m-d H:i:s', $entity->created->timestamp),
                'classNames' => $classes
            ];
        }

        $this->set('chartData', $chartData);
        $this->set('events', $events);

        $this->viewBuilder()->setOption('serialize', ['chartData', 'events']);
    }
}
