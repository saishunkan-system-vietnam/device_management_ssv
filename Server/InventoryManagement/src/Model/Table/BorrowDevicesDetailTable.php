<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BorrowDevicesDetail Model
 *
 * @property \App\Model\Table\BorrowDevicesTable|\Cake\ORM\Association\BelongsTo $BorrowDevices
 * @property \App\Model\Table\DevicesTable|\Cake\ORM\Association\BelongsTo $Devices
 *
 * @method \App\Model\Entity\BorrowDevicesDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\BorrowDevicesDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BorrowDevicesDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BorrowDevicesDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BorrowDevicesDetail|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BorrowDevicesDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BorrowDevicesDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BorrowDevicesDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class BorrowDevicesDetailTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('borrow_devices_detail');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('BorrowDevices', [
            'foreignKey' => 'borrow_device_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('borrow_reason')
            ->allowEmptyString('borrow_reason');

        $validator
            ->scalar('return_reason')
            ->allowEmptyString('return_reason');

        $validator
            ->integer('status')
            ->allowEmptyString('status');

        $validator
            ->dateTime('borrow_date')
            ->requirePresence('borrow_date', 'create')
            ->allowEmptyDateTime('borrow_date', false);

        $validator
            ->dateTime('approved_date')
            ->allowEmptyDateTime('approved_date');

        $validator
            ->dateTime('delivery_date')
            ->allowEmptyDateTime('delivery_date');

        $validator
            ->dateTime('return_date')
            ->requirePresence('return_date', 'create')
            ->allowEmptyDateTime('return_date', false);

        $validator
            ->scalar('created_user')
            ->maxLength('created_user', 100)
            ->allowEmptyString('created_user');

        $validator
            ->scalar('update_user')
            ->maxLength('update_user', 100)
            ->allowEmptyString('update_user');

        $validator
            ->dateTime('created_time')
            ->allowEmptyDateTime('created_time');

        $validator
            ->dateTime('update_time')
            ->allowEmptyDateTime('update_time');

        $validator
            ->boolean('is_deleted')
            ->requirePresence('is_deleted', 'create')
            ->allowEmptyString('is_deleted', false);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['borrow_device_id'], 'BorrowDevices'));
        $rules->add($rules->existsIn(['device_id'], 'Devices'));

        return $rules;
    }
}
