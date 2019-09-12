<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Lib\Traits\PaginationTrait;
use App\Lib\Api\ApiPaginator;

/**
 * Measurements Model
 *
 * @method \App\Model\Entity\Measurement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Measurement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Measurement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Measurement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Measurement saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Measurement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Measurement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Measurement findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MeasurementsTable extends Table
{

    use PaginationTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('measurements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->nonNegativeInteger('systolic')
            ->requirePresence('systolic', 'create')
            ->notEmptyString('systolic');

        $validator
            ->nonNegativeInteger('diastolic')
            ->requirePresence('diastolic', 'create')
            ->notEmptyString('diastolic');

        $validator
            ->nonNegativeInteger('heart_rate')
            ->requirePresence('heart_rate', 'create')
            ->notEmptyString('heart_rate');

        return $validator;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function existsById($id)
    {
        return $this->exists(['Measurements.id' => $id]);
    }

    /**
     * @param int $id
     * @param int $userId
     * @return bool
     */
    public function existsByIdAndUserId($id, $userId)
    {
        return $this->exists([
            'Measurements.id' => $id,
            'Measurements.user_id' => $userId
        ]);
    }

    public function getMeasurementsIndex(ApiPaginator $ApiPaginator, int $userId): array
    {
        $query = $this->find()
            ->where([
                'Measurements.user_id' => $userId
            ])
            ->order([
                'Measurements.created' => 'DESC'
            ]);
        return $this->paginate($query, $ApiPaginator);
    }

    public function getMeasurementsDashboard(int $start, int $end, int $userId): array
    {
        $query = $this->find()
            ->where([
                'Measurements.user_id' => $userId,
                'Measurements.created <=' => date('Y-m-d H:i:s', $start),
                'Measurements.created >=' => date('Y-m-d H:i:s', $end)
            ])
            ->order([
                'Measurements.created' => 'asc'
            ])
            ->all();

        if($query === null){
            return [];
        }

        return $query->toArray();
    }
}
