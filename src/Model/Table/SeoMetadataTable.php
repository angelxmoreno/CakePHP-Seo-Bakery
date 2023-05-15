<?php
declare(strict_types=1);

namespace SeoBakery\Model\Table;

use Cake\Database\Schema\TableSchemaInterface;
use Cake\Datasource\EntityInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use SeoBakery\Model\Entity\SeoMetadata;

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
            ->maxLength('name', 500)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('uri')
            ->maxLength('uri', 500)
            ->notEmptyString('uri')
            ->add('uri', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('canonical')
            ->maxLength('canonical', 500)
            ->allowEmptyString('canonical')
            ->add('canonical', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
            ->scalar('meta_description')
            ->maxLength('meta_description', 200)
            ->allowEmptyString('meta_description');

        $validator
            ->isArray('meta_keywords')
            ->allowEmptyArray('meta_keywords');

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
     * @param RulesChecker $rules The rules object to be modified.
     * @return RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['name']), ['errorField' => 'name']);
        $rules->add($rules->isUnique(['uri']), ['errorField' => 'uri']);
        $rules->add($rules->isUnique(['canonical'], ['allowMultipleNulls' => true]), ['errorField' => 'canonical']);
        $rules->add($rules->isUnique(['table_alias', 'table_identifier', 'action'], ['allowMultipleNulls' => true]), ['errorField' => 'table_alias']);

        return $rules;
    }

    public function findOrCreateByRequest(array $data = [], ?ServerRequest $request = null): SeoMetadata
    {
        $request = $request ?? Router::getRequest();
        $name = $this->buildNameFromRequestParams($request);
        $knownVars = [
            'name' => $name,
            'prefix' => $request->getParam('prefix'),
            'plugin' => $request->getParam('plugin'),
            'controller' => $request->getParam('controller'),
            'action' => $request->getParam('action'),
            'passed' => $request->getParam('pass'),
            'uri' => $request->getRequestTarget(),
        ];
        $seoMetadata = $this->findOrCreate(compact('name'));
        $seoMetadata = $this->patchEntityNulls($seoMetadata, array_merge($data, $knownVars), []);
        $this->saveOrFail($seoMetadata);

        return $seoMetadata;
    }

    public function patchEntityNulls(SeoMetadata $entity, array $data, array $options = []): SeoMetadata
    {
        $data = array_merge($data, $entity->toArray());
        unset($data['created']);
        unset($data['modified']);
        return $this->patchEntity($entity, $data, $options);
    }

    public function buildNameFromRequestParams(?ServerRequest $request = null): string
    {
        $request = $request ?? Router::getRequest();
        $controller = $request->getParam('controller', '');
        $pass = $request->getParam('pass', []);

        /**
         * special treatment for the Pages controller
         */
        if ($controller === 'Pages' && $pass[0] === 'display') {
            unset($pass[0]);
        }

        $passed = array_reduce($pass, fn($v1, $v2) => sprintf('%s:%s', $v1, $v2), '');

        return sprintf(
            '%s-%s-%s-%s-%s',
            $request->getParam('prefix', null),
            $request->getParam('plugin', ''),
            $controller,
            $request->getParam('action', ''),
            $passed
        );
    }
}