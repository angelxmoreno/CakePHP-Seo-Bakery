<?php
declare(strict_types=1);

namespace SeoBakery\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Shared\SeoMetadataTableAware;

/**
 * PagesMetadata component
 */
class PagesMetadataComponent extends Component
{
    use SeoMetadataTableAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'templates' => [],
    ];

    public function beforeRender(EventInterface $event)
    {
        $seoMetadata = null;
        /** @var Controller $controller */
        $controller = $event->getSubject();
        $template = trim($controller->viewBuilder()->getTemplate(), '/');
        if ($this->isQualifyingRequest($template) && $controller->getName() === 'Pages') {
            $seoMetadata = $this->getPagesSeoMetadata($template);
        }

        if ($seoMetadata) $this->getController()->set(compact('seoMetadata'));
    }

    protected function getPagesSeoMetadata(string $template): SeoMetadata
    {

        $name = implode(':', [
            'Pages',
            $template,
        ]);

        return $this->getSeoMetadataTable()->findOrCreate(compact('name'), function (SeoMetadata $entity) use ($template) {
            $this->getSeoMetadataTable()->patchEntity($entity, [
                'name' => $entity->name,
                'table_alias' => 'Pages',
                'table_identifier' => null,
                'prefix' => null,
                'plugin' => null,
                'controller' => 'Pages',
                'action' => 'display',
                'passed' => explode('/', $template),
                'meta_title_fallback' => $this->buildMetaTitle($template),
                'meta_description_fallback' => $this->buildMetaDescription($template),
                'meta_keywords_fallback' => $this->buildMetaKeywords($template),
                'noindex' => !$this->buildShouldIndex($template),
                'nofollow' => !$this->buildShouldFollow($template),
            ]);
        });
    }

    protected function buildMetaTitle(string $template): ?string
    {
        $method = $this->getConfig('buildTitleFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_string($method)) return $method;
        return ucfirst(str_replace('/', ' ', mb_strtolower($template)));
    }

    protected function buildMetaDescription(string $template): ?string
    {
        $method = $this->getConfig('buildDescriptionFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_string($method)) return $method;

        return 'The ' . $this->buildMetaTitle($template) . ' page';
    }

    protected function buildMetaKeywords(string $template): array
    {
        $method = $this->getConfig('buildKeywordsFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_array($method)) return $method;
        return explode(' ', $this->buildMetaTitle($template));
    }

    protected function buildShouldIndex(string $template): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('buildShouldIndexFunc');
        if ($method && is_callable($method)) return (bool)$method($template);
        if ($method && is_bool($method)) return $method;
        return true;
    }

    protected function buildShouldFollow(string $template): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('buildShouldFollowFunc');
        if ($method && is_callable($method)) return (bool)$method($template);
        if ($method && is_bool($method)) return $method;
        return true;
    }

    protected function isQualifyingRequest(string $template): bool
    {
        return array_key_exists($template, $this->getConfig('templates'));
    }
}
