<?php

declare(strict_types=1);

namespace SeoBakery\Model\Table;

use Cake\Database\Schema\TableSchemaInterface;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SeoBakery\Core\SeoAwareEntityTrait;
use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Core\SeoAwareListViewObject;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Shared\InstanceUses;

/**
 * SeoMetadata Model
 *
 * @method SeoMetadata newEmptyEntity()
 * @method SeoMetadata newEntity(array $data, array $options = [])
 * @method SeoMetadata[] newEntities(array $data, array $options = [])
 * @method SeoMetadata get($primaryKey, $options = [])
 * @method SeoMetadata findOrCreate($search, ?callable $callback = null, $options = [])
 * @method SeoMetadata patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method SeoMetadata[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method SeoMetadata|false save(EntityInterface $entity, $options = [])
 * @method SeoMetadata saveOrFail(EntityInterface $entity, $options = [])
 * @method SeoMetadata[]|ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method SeoMetadata[]|ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method SeoMetadata[]|ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method SeoMetadata[]|ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin TimestampBehavior
 */
class SeoMetadataTable extends Table
{
    public const MISSING_FIELDS_OPTIONS = [
        'meta_title',
        'meta_description',
        'canonical',
        'image_url',
        'image_alt',
    ];

    public const OPTIMIZED_OPTIONS = [
        'True',
        'False',
    ];

    public const SORT_FIELDS_OPTIONS = [
        'name',
        'canonical',
        'table_alias',
        'table_identifier',
        'prefix',
        'plugin',
        'controller',
        'action',
        'passed',
        'meta_title',
        'meta_title_fallback',
        'meta_description',
        'meta_description_fallback',
        'meta_keywords',
        'meta_keywords_fallback',
        'noindex',
        'nofollow',
        'image_url',
        'image_alt',
        'created',
        'modified',
    ];

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
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * @param TableSchemaInterface $schema
     * @return TableSchemaInterface
     */
    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType('passed', 'json');
        $schema->setColumnType('meta_keywords', 'json');
        $schema->setColumnType('meta_keywords_fallback', 'json');

        return $schema;
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 500, 'Name is too long')
            ->requirePresence('name', 'create', 'Name is required')
            ->notEmptyString('name', 'Name can not be an empty string')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('canonical')
            ->maxLength('canonical', 500)
            ->allowEmptyString('canonical')
            ->add('canonical', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('uri')
            ->maxLength('uri', 500)
            ->allowEmptyString('uri')
            ->add('uri', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('table_alias')
            ->maxLength('table_alias', 100)
            ->allowEmptyString('table_alias');

        $validator
            ->nonNegativeInteger('table_identifier')
            ->allowEmptyString('table_identifier');

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
            ->isArray('passed')
            ->allowEmptyArray('passed');

        $validator
            ->scalar('meta_title')
            ->maxLength('meta_title', 200)
            ->allowEmptyString('meta_title');

        $validator
            ->scalar('meta_title_fallback')
            ->maxLength('meta_title_fallback', 200)
            ->allowEmptyString('meta_title_fallback');

        $validator
            ->scalar('meta_description')
            ->maxLength('meta_description', 200)
            ->allowEmptyString('meta_description');

        $validator
            ->scalar('meta_description_fallback')
            ->maxLength('meta_description_fallback', 200)
            ->allowEmptyString('meta_description_fallback');

        $validator
            ->isArray('meta_keywords')
            ->allowEmptyArray('meta_keywords');

        $validator
            ->isArray('meta_keywords_fallback')
            ->allowEmptyString('meta_keywords_fallback');

        $validator
            ->boolean('noindex')
            ->allowEmptyString('noindex');

        $validator
            ->boolean('nofollow')
            ->allowEmptyString('nofollow');

        $validator
            ->scalar('image_url')
            ->allowEmptyString('image_url');

        $validator
            ->scalar('image_alt')
            ->allowEmptyString('image_alt');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);
        $rules->add($rules->isUnique(['canonical'], ['allowMultipleNulls' => true]), ['errorField' => 'canonical']);
        $rules->add($rules->isUnique(['uri'], ['allowMultipleNulls' => true]), ['errorField' => 'uri']);
        $rules->add($rules->isUnique(['table_alias', 'table_identifier', 'action'], ['allowMultipleNulls' => true]), ['errorField' => 'table_alias']);

        return $rules;
    }

    public function fetchUniqueTableAliasList(): array
    {
        $tables = $this
            ->find('list', [
                'keyField' => 'table_alias',
                'valueField' => 'table_alias',
            ])
            ->select('table_alias')
            ->distinct('table_alias')
            ->whereNotNull('table_alias')
            ->all()
            ->toArray();


        return [
                0 => 'All',
                null => 'None',
            ] + $tables;
    }

    public function fromSeoAwareObj(SeoAwareInterface $obj, string $action): ?SeoMetadata
    {
        $data = array_merge($obj->getPrefixPluginControllerArray(), [
            'table_alias' => null,
            'table_identifier' => null,
            'name' => $obj->buildSeoName($action),
            'action' => $action,

            'meta_title_fallback' => $obj->buildMetaTitleFallback($action),
            'meta_description_fallback' => $obj->buildMetaDescriptionFallback($action),
            'meta_keywords_fallback' => $obj->buildMetaKeywordsFallback($action),
            'noindex' => !$obj->buildRobotsShouldIndex($action),
            'nofollow' => !$obj->buildRobotsShouldFollow($action),
            'image_url' => $obj->buildImageUrl($action),
            'image_alt' => $obj->buildImageAlt($action),
            'uri' => $obj->buildUrl($action),
        ]);
        if (InstanceUses::check($obj, SeoAwareEntityTrait::class)) {
            /** @var SeoAwareEntityTrait $obj */
            $data['table_alias'] = $obj->getEntityTable()->getAlias();
            $data['table_identifier'] = $obj->getPrimaryKeyValue();
        }

        if (is_subclass_of($obj, SeoAwareListViewObject::class)) {
            /** @var SeoAwareListViewObject $obj */
            $data['table_alias'] = $obj->getTable()->getAlias();
        }

        $entity = $this->findOrCreate([
            'name' => $data['name'],
        ]);

        $entity = $this->patchEntity($entity, $data);
        $this->save($entity);
        return $entity;
    }
}
