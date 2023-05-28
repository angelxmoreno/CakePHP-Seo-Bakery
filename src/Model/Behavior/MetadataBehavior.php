<?php

declare(strict_types=1);

namespace SeoBakery\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use SeoBakery\Core\SeoAwareEntityTrait;
use SeoBakery\Core\SeoAwareEntityWrapper;
use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Core\SeoAwareRegistry;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Shared\InstanceUses;
use SeoBakery\Shared\SeoMetadataTableAware;

/**
 * Metadata behavior
 */
class MetadataBehavior extends Behavior
{
    use SeoMetadataTableAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'actions' => ['view'],
        'identifierFunc' => 0,
    ];

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->addEntityToRegistry();
    }

    protected function addEntityToRegistry()
    {
        $entity = $this->table()->newEmptyEntity();
        $entity = $this->wrapEntity($entity);
        SeoAwareRegistry::add($entity);
    }

    /**
     * @param EventInterface $event
     * @param EntityInterface $entity
     * @return void
     */
    public function afterSave(EventInterface $event, EntityInterface $entity)
    {
        $this->buildMetadataActions($entity);
    }

    /**
     * @param EntityInterface $entity
     * @return void
     */
    public function buildMetadataActions(EntityInterface $entity)
    {
        $actions = array_unique($this->getConfig('actions'));
        if (!InstanceUses::check($entity, SeoAwareEntityTrait::class)) {
            $entity = $this->wrapEntity($entity);
        }
        foreach ($actions as $action) {
            $this->getSeoMetadataTable()->fromSeoAwareObj($entity, $action);
        }
    }

    /**
     * @param array $options
     * @return SeoMetadata|EntityInterface|null
     */
    public function fetchMetaDataByRequest(array $options = []): ?SeoMetadata
    {
        $request = Hash::get($options, 'request', Router::getRequest());
        $pass = $request->getParam('pass');
        $action = $request->getParam('action');

        $lookUp = [
            'table_alias' => $this->table()->getAlias(),
            'prefix IS' => $request->getParam('prefix'),
            'plugin IS' => $request->getParam('plugin'),
            'controller' => $request->getParam('controller'),
            'action' => $action,
        ];
        $exists = $this->getSeoMetadataTable()->exists($lookUp);
        if (!$exists) {
            return null;
        }

        $identifierFunc = $this->getConfig('identifierFunc');
        $tableIdentifier = is_callable($identifierFunc) ? $identifierFunc($pass, $action) : $pass[$identifierFunc];
        $lookUp['table_identifier'] = $tableIdentifier;
        return $this->getSeoMetadataTable()->find()->where($lookUp)->first();
    }

    /**
     * @param EntityInterface $entity
     * @return SeoAwareInterface|EntityInterface
     */
    protected function wrapEntity(EntityInterface $entity): SeoAwareInterface
    {
        return new SeoAwareEntityWrapper($entity, $this->table());
    }
}
