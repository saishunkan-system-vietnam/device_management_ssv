<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BorrowDevices Model
 *
 * @property \App\Model\Table\BorrowersTable|\Cake\ORM\Association\BelongsTo $Borrowers
 * @property \App\Model\Table\ApprovedsTable|\Cake\ORM\Association\BelongsTo $Approveds
 * @property \App\Model\Table\HandoversTable|\Cake\ORM\Association\BelongsTo $Handovers
 * @property \App\Model\Table\BorrowDevicesDetailTable|\Cake\ORM\Association\HasMany $BorrowDevicesDetail
 *
 * @method \App\Model\Entity\BorrowDevice get($primaryKey, $options = [])
 * @method \App\Model\Entity\BorrowDevice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\BorrowDevice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BorrowDevice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BorrowDevice|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\BorrowDevice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\BorrowDevice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\BorrowDevice findOrCreate($search, callable $callback = null, $options = [])
 */
class BorrowDevicesTable extends Table
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

        $this->setTable('borrow_devices');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Borrowers', [
            'foreignKey' => 'borrower_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Approveds', [
            'foreignKey' => 'approved_id'
        ]);
        $this->belongsTo('Handovers', [
            'foreignKey' => 'handover_id'
        ]);
        $this->hasMany('BorrowDevicesDetail', [
            'foreignKey' => 'borrow_device_id'
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
        $rules->add($rules->existsIn(['borrower_id'], 'Borrowers'));
        $rules->add($rules->existsIn(['approved_id'], 'Approveds'));
        $rules->add($rules->existsIn(['handover_id'], 'Handovers'));

        return $rules;
    }
}
