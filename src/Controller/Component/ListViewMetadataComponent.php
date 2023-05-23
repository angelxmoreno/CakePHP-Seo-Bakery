<?php
declare(strict_types=1);

namespace SeoBakery\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Http\ServerRequest;
use Cake\ORM\Table;
use SeoBakery\Model\Behavior\MetadataBehavior;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Shared\SeoMetadataTableAware;

/**
 * PagesMetadata component
 */
class ListViewMetadataComponent extends Component
{
    use SeoMetadataTableAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function startup(EventInterface $event)
    {
        $seoMetadata = null;
        /** @var Controller $controller */
        $controller = $event->getSubject();
        if ($this->isQualifyingRequest()) {
            $seoMetadata = $this->getSeoMetadata();
        }

        if ($seoMetadata) {
            $path = $this->getRequest()->getUri()->getPath();
            if ($seoMetadata->canonical && $path <> $seoMetadata->canonical) {
                $controller->redirect($this->getRequest()->getUri()->withPath($seoMetadata->canonical));
            }
            $this->getController()->set(compact('seoMetadata'));
        }
    }

    protected function getSeoMetadata(): SeoMetadata
    {

        $name = implode(':', [
            $this->getConfig('controller'),
            $this->getRequest()->getParam('action'),
        ]);
        $table = $this->getModelTable();
        $action = $this->getRequest()->getParam('action');
        return $this->getSeoMetadataTable()->findOrCreate(compact('name'), function (SeoMetadata $entity) use ($table, $action) {
            $this->getSeoMetadataTable()->patchEntity($entity, [
                'name' => $entity->name,
                'table_alias' => $this->getConfig('model'),
                'table_identifier' => null,
                'prefix' => $this->getConfig('prefix'),
                'plugin' => $this->getConfig('plugin'),
                'controller' => $this->getConfig('controller'),
                'action' => $action,
                'passed' => [],
                'meta_title_fallback' => $this->buildMetaTitle($table, $action),
                'meta_description_fallback' => $this->buildMetaDescription($table, $action),
                'meta_keywords_fallback' => $this->buildMetaKeywords($table, $action),
                'noindex' => !$this->buildShouldIndex($table, $action),
                'nofollow' => !$this->buildShouldFollow($table, $action),
            ]);
        });
    }

    protected function buildMetaTitle(Table $table, string $action): ?string
    {
        $method = $this->getConfig('buildTitleFunc');
        if ($method && is_callable($method)) return $method($table, $action);
        if ($method && is_string($method)) return $method;
        return null;
    }

    protected function buildMetaDescription(Table $table, string $action): ?string
    {
        $method = $this->getConfig('buildDescriptionFunc');
        if ($method && is_callable($method)) return $method($table, $action);
        if ($method && is_string($method)) return $method;

        return null;
    }

    protected function buildMetaKeywords(Table $table, string $action): array
    {
        $method = $this->getConfig('buildKeywordsFunc');
        if ($method && is_callable($method)) return $method($table, $action);
        if ($method && is_array($method)) return $method;
        return [];
    }

    protected function buildShouldIndex(Table $table, string $action): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('buildShouldIndexFunc');
        if ($method && is_callable($method)) return (bool)$method($table, $action);
        if ($method && is_bool($method)) return $method;
        return true;
    }

    protected function buildShouldFollow(Table $table, string $action): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('buildShouldFollowFunc');
        if ($method && is_callable($method)) return (bool)$method($table, $action);
        if ($method && is_bool($method)) return $method;
        return true;
    }

    protected function isQualifyingRequest(): bool
    {
        return
            $this->getConfig('prefix') === $this->getRequest()->getParam('prefix') &&
            $this->getConfig('plugin') === $this->getRequest()->getParam('plugin') &&
            $this->getConfig('controller') === $this->getRequest()->getParam('controller') &&
            in_array($this->getRequest()->getParam('action'), $this->getConfig('actions'));
    }

    /**
     * @return Table&MetadataBehavior
     */
    protected function getModelTable(): Table
    {
        return $this->fetchTable($this->getConfig('model'));
    }

    /**
     * @return ServerRequest
     */
    protected function getRequest(): ServerRequest
    {
        return $this->getController()->getRequest();
    }
}
