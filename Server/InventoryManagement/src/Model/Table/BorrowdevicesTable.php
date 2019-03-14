<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Borrowdevice Model
 *
 * @property \App\Model\Table\BorrowersTable|\Cake\ORM\Association\BelongsTo $Borrowers
 * @property \App\Model\Table\ApprovedsTable|\Cake\ORM\Association\BelongsTo $Approveds
 * @property \App\Model\Table\HandoversTable|\Cake\ORM\Association\BelongsTo $Handovers
 * @property \App\Model\Table\DevicesTable|\Cake\ORM\Association\BelongsTo $Devices
 *
 * @method \App\Model\Entity\Borrowdevice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Borrowdevice newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Borrowdevice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Borrowdevice|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Borrowdevice|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Borrowdevice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Borrowdevice[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Borrowdevice findOrCreate($search, callable $callback = null, $options = [])
 */
class BorrowdeviceTable extends Table
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

        $this->setTable('borrowdevice');
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
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('note')
            ->allowEmptyString('note');

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
            ->dateTime('returnee_date')
            ->requirePresence('returnee_date', 'create')
            ->allowEmptyDateTime('returnee_date', false);

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
        $rules->add($rules->existsIn(['device_id'], 'Devices'));

        return $rules;
    }
}
