<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Devices Model
 *
 * @property \App\Model\Table\DevicesTable|\Cake\ORM\Association\BelongsTo $ParentDevices
 * @property \App\Model\Table\BrandsTable|\Cake\ORM\Association\BelongsTo $Brands
 * @property \App\Model\Table\BorrowDevicesDetailTable|\Cake\ORM\Association\HasMany $BorrowDevicesDetail
 * @property |\Cake\ORM\Association\HasMany $ChildDevices
 *
 * @method \App\Model\Entity\Device get($primaryKey, $options = [])
 * @method \App\Model\Entity\Device newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Device[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Device|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Device saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Device patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Device[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Device findOrCreate($search, callable $callback = null, $options = [])
 */
class DevicesTable extends Table
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

        $this->setTable('devices');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('ParentDevices', [
            'className' => 'Devices',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Brands', [
            'foreignKey' => 'brand_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('BorrowDevicesDetail', [
            'foreignKey' => 'device_id'
        ]);
        $this->hasMany('ChildDevices', [
            'className' => 'Devices',
            'foreignKey' => 'parent_id'
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
            ->integer('id_cate')
            ->requirePresence('id_cate', 'create')
            ->allowEmptyString('id_cate', false);

        $validator
            ->scalar('serial_number')
            ->maxLength('serial_number', 50)
            ->requirePresence('serial_number', 'create')
            ->allowEmptyString('serial_number', false);

        $validator
            ->scalar('product_number')
            ->maxLength('product_number', 50)
            ->requirePresence('product_number', 'create')
            ->allowEmptyString('product_number', false);

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('specifications')
            ->allowEmptyString('specifications');

        $validator
            ->allowEmptyString('status');

        $validator
            ->dateTime('stock_date')
            ->allowEmptyDateTime('stock_date');

        $validator
            ->dateTime('warranty_period')
            ->allowEmptyDateTime('warranty_period');

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
            ->allowEmptyString('is_deleted',false);

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
        return $rules;
    }
}
