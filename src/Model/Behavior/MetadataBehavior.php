<?php
declare(strict_types=1);

namespace SeoBakery\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Model\Table\SeoMetadataTable;

/**
 * Metadata behavior
 */
class MetadataBehavior extends Behavior
{
    use LocatorAwareTrait;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'actions' => ['view'],
        'buildTitleFunc' => null,
        'buildDescriptionFunc' => null,
        'buildKeywordsFunc' => null,
        'buildRobotsFunc' => null,
        'buildShouldIndexFunc' => null,
        'buildShouldFollowFunc' => null,
    ];

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->buildMetadataActionsFromEntity($entity);
    }

    public function buildMetadataFromEntity(EntityInterface $entity, array $data = []): SeoMetadata
    {
        $data = array_merge([
            'table_alias' => $this->table()->getAlias(),
            'table_identifier' => $entity->get($this->table()->getPrimaryKey()),
            'meta_title' => $this->buildMetaTitle($entity),
            'meta_description' => $this->buildMetaDescription($entity),
            'meta_tags' => $this->buildMetaKeywords($entity),
        ], $data);

        return $this->getSeoMetadataTable()->findOrCreateByRequest($data);
    }

    public function buildMetadataActionsFromEntity(EntityInterface $entity, array $data = [])
    {
        $actions = array_unique($this->getConfig('actions'));
        $route = [
            'prefix' => $this->getConfig('prefix'),
            'plugin' => $this->getConfig('plugin'),
            'controller' => $this->getConfig('controller', $this->table()->getAlias()),
        ];

        foreach ($actions as $action) {
            $data = array_merge($route, $this->buildDataArrayForAction($entity, $action));
            $this->getSeoMetadataTable()->findOrCreateByRequest($data);
        }
    }

    protected function buildDataArrayForAction(EntityInterface $entity, string $action): array
    {
        return [
            'table_alias' => $this->table()->getAlias(),
            'table_identifier' => $entity->get($this->table()->getPrimaryKey()),
            'meta_title' => $this->buildMetaTitle($entity, $action),
            'meta_description' => $this->buildMetaDescription($entity, $action),
            'meta_tags' => $this->buildMetaKeywords($entity, $action),
            'noindex' => !$this->buildShouldIndex($entity, $action),
            'nofollow' => !$this->buildShouldFollow($entity, $action),
            'action' => $action,
        ];
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
        $method = $this->getConfig('buildShouldIndexFunc');
        if ($method && is_callable($method)) return (bool)$method($entity, $action);
        return $action === 'view';
    }

    protected function buildShouldFollow(EntityInterface $entity, string $action): bool
    {
        $method = $this->getConfig('buildShouldIndexFunc');
        if ($method && is_callable($method)) return (bool)$method($entity, $action);
        return $action === 'view';
    }

    /**
     * @return SeoMetadataTable|Table
     */
    protected function getSeoMetadataTable(): SeoMetadataTable
    {
        return $this->fetchTable(SeoMetadataTable::class);
    }
}
