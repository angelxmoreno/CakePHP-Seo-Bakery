<?php
declare(strict_types=1);

namespace SeoBakery\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SeoMetadata Model
 *
 * @method \SeoBakery\Model\Entity\SeoMetadata newEmptyEntity()
 * @method \SeoBakery\Model\Entity\SeoMetadata newEntity(array $data, array $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata[] newEntities(array $data, array $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata get($primaryKey, $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \SeoBakery\Model\Entity\SeoMetadata[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SeoMetadataTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('seo_metadata');
        $this->setDisplayField('url');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('url')
            ->maxLength('url', 500)
            ->notEmptyString('url')
            ->add('url', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('canonical')
            ->maxLength('canonical', 500)
            ->allowEmptyString('canonical')
            ->add('canonical', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('entity_class')
            ->maxLength('entity_class', 100)
            ->allowEmptyString('entity_class');

        $validator
            ->nonNegativeInteger('entity_identifier')
            ->allowEmptyString('entity_identifier');

        $validator
            ->scalar('prefix')
            ->maxLength('prefix', 100)
            ->allowEmptyString('prefix');

        $validator
            ->scalar('plugin')
            ->maxLength('plugin', 100)
            ->allowEmptyString('plugin');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 100)
            ->allowEmptyString('controller');

        $validator
            ->scalar('action')
            ->maxLength('action', 100)
            ->allowEmptyString('action');

        $validator
            ->scalar('passed')
            ->maxLength('passed', 200)
            ->allowEmptyString('passed');

        $validator
            ->scalar('title')
            ->maxLength('title', 200)
            ->allowEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 200)
            ->allowEmptyString('description');

        $validator
            ->scalar('keywords')
            ->allowEmptyString('keywords');

        $validator
            ->boolean('noindex')
            ->allowEmptyString('noindex');

        $validator
            ->boolean('nofollow')
            ->allowEmptyString('nofollow');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['url']), ['errorField' => 'url']);
        $rules->add($rules->isUnique(['canonical'], ['allowMultipleNulls' => true]), ['errorField' => 'canonical']);

        return $rules;
    }
}
