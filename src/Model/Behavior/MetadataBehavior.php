<?php
declare(strict_types=1);

namespace SeoBakery\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use SeoBakery\Model\Entity\SeoMetadata;
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
        'prefix' => null,
        'plugin' => null,
        'controller' => null,
        'actions' => ['view'],
        'identifierFunc' => 0,
        'buildTitleFunc' => null,
        'buildDescriptionFunc' => null,
        'buildKeywordsFunc' => null,
        'buildShouldIndexFunc' => null,
        'buildShouldFollowFunc' => null,
    ];

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

        foreach ($actions as $action) {
            $data = $this->buildMetaDataAction($entity, $action);
            $seoMetadata = $this->getSeoMetadataTable()->findOrCreate([
                'name' => $data['name'],
            ]);
            $seoMetadata = $this->getSeoMetadataTable()->patchEntity($seoMetadata, $data);
            $this->getSeoMetadataTable()->saveOrFail($seoMetadata);
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
        if (!$exists) return null;
        $identifierFunc = $this->getConfig('identifierFunc');

        if (is_callable($identifierFunc)) {
            $tableIdentifier = $identifierFunc($pass, $action);
        } else {
            $tableIdentifier = $pass[$identifierFunc];
        }
        $lookUp['table_identifier'] = $tableIdentifier;
        return $this->getSeoMetadataTable()->find()->where($lookUp)->first();
    }

    protected function buildMetaDataAction(EntityInterface $entity, string $action): array
    {
        $data = [
            'table_alias' => $this->table()->getAlias(),
            'table_identifier' => $entity->get($this->table()->getPrimaryKey()),
            'prefix' => $this->getConfig('prefix'),
            'plugin' => $this->getConfig('plugin'),
            'controller' => $this->getConfig('controller', $this->table()->getAlias()),
            'action' => $action,
            'meta_title_fallback' => $this->buildMetaTitle($entity, $action),
            'meta_description_fallback' => $this->buildMetaDescription($entity, $action),
            'meta_keywords_fallback' => $this->buildMetaKeywords($entity, $action),
            'noindex' => !$this->buildShouldIndex($entity, $action),
            'nofollow' => !$this->buildShouldFollow($entity, $action),
        ];

        $data['name'] = implode(':', [
            $data['table_alias'],
            $data['action'],
            $data['table_identifier'],
        ]);

        return $data;
    }

    protected function buildMetaTitle(EntityInterface $entity, string $action): ?string
    {
        $method = $this->getConfig('buildTitleFunc');
        if ($method && is_callable($method)) return $method($entity, $action);
        return $entity->get($this->table()->getDisplayField());
    }

    protected function buildMetaDescription(EntityInterface $entity, string $action): ?string
    {
        $method = $this->getConfig('buildDescriptionFunc');
        if ($method && is_callable($method)) return $method($entity, $action);
        return 'About ' . $this->buildMetaTitle($entity, $action);
    }

    protected function buildMetaKeywords(EntityInterface $entity, string $action): array
    {
        $method = $this->getConfig('buildKeywordsFunc');
        if ($method && is_callable($method)) return $method($entity, $action);
        return explode(' ', $this->buildMetaTitle($entity, $action));
    }

    protected function buildShouldIndex(EntityInterface $entity, string $action): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('buildShouldIndexFunc');
        if ($method && is_callable($method)) return (bool)$method($entity, $action);
        if ($method && is_bool($method)) return $method;
        return $action === 'view';
    }

    protected function buildShouldFollow(EntityInterface $entity, string $action): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('buildShouldFollowFunc');
        if ($method && is_callable($method)) return (bool)$method($entity, $action);
        if ($method && is_bool($method)) return $method;
        return $action === 'view';
    }
}
