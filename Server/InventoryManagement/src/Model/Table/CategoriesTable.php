<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;


/**
 * Categories Model
 *
 * @method \App\Model\Entity\Category get($primaryKey, $options = [])
 * @method \App\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Category findOrCreate($search, callable $callback = null, $options = [])
 */
class CategoriesTable extends Table
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

        $this->setTable('categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->integer('id_parent')
            ->allowEmptyString('id_parent');

        $validator
            ->scalar('category_name')
            ->maxLength('category_name', 100)
            ->requirePresence('category_name', 'create')
            ->allowEmptyString('category_name', false);

        $validator
            ->dateTime('created_time')
            ->allowEmptyDateTime('created_time');

        $validator
            ->dateTime('update_time')
            ->allowEmptyDateTime('update_time');


        return $validator;
    }

    /**
     *  Check category name unique
     */
    public function buildRules(RulesChecker $rules){
        $rules->add($rules->isUnique(['category_name']));
        return $rules;
        $validator
            ->boolean('is_deleted')
            ->requirePresence('is_deleted', 'create')
            ->allowEmptyString('is_deleted', false);

        return $validator;
    }
}
