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
use SeoBakery\Shared\SeoMetadataAware;

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
        'buildTitleFunc' => null,
        'buildDescriptionFunc' => null,
        'buildKeywordsFunc' => null,
    ];

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->buildMetadataFromEntity($entity);
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

    protected function buildMetaTitle(EntityInterface $entity): ?string
    {
        $method = $this->getConfig('buildTitleFunc');
        if ($method && is_callable($method)) return $method($entity);
        return $entity->get($this->table()->getDisplayField());
    }

    protected function buildMetaDescription(EntityInterface $entity): ?string
    {
        $method = $this->getConfig('buildDescriptionFunc');
        if ($method && is_callable($method)) return $method($entity);
        return 'About ' . $this->buildMetaTitle($entity);
    }

    protected function buildMetaKeywords(EntityInterface $entity): array
    {
        $method = $this->getConfig('buildKeywordsFunc');
        if ($method && is_callable($method)) return $method($entity);
        return explode(' ', $this->buildMetaTitle($entity));
    }

    /**
     * @return SeoMetadataTable|Table
     */
    protected function getSeoMetadataTable(): SeoMetadataTable
    {
        return $this->fetchTable(SeoMetadataTable::class);
    }
}
