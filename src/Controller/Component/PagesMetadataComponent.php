<?php
declare(strict_types=1);

namespace SeoBakery\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Http\ServerRequest;
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

    public function startup(EventInterface $event)
    {
        $seoMetadata = null;
        /** @var Controller $controller */
        $controller = $event->getSubject();
        $template = implode($this->getRequest()->getParam('pass'));
        if ($this->isQualifyingRequest($template) && $controller->getName() === 'Pages') {
            $seoMetadata = $this->getPagesSeoMetadata($template);
        }
        if ($seoMetadata) {
            $path = $this->getRequest()->getUri()->getPath();
            if ($seoMetadata->canonical && $path <> $seoMetadata->canonical) {
                $controller->redirect($this->getRequest()->getUri()->withPath($seoMetadata->canonical));
            }
            $this->getController()->set(compact('seoMetadata'));
        }
    }

    protected function getPagesSeoMetadata(string $template): SeoMetadata
    {
        $name = implode(':', [
            'Pages',
            $template,
        ]);

        $seoMetadata = $this->getSeoMetadataTable()->findOrCreate(compact('name'), function (SeoMetadata $entity) use ($template) {
            $this->getSeoMetadataTable()->patchEntity($entity, [
                'name' => $entity->name,
                'table_alias' => 'Pages',
                'table_identifier' => null,
                'prefix' => null,
                'plugin' => null,
                'controller' => 'Pages',
                'action' => 'display',
                'passed' => explode('/', $template),
            ]);
        });

        $seoMetadata = $this->getSeoMetadataTable()->patchEntity($seoMetadata, [
            'name' => $seoMetadata->name,
            'meta_title_fallback' => $this->buildMetaTitle($template),
            'meta_description_fallback' => $this->buildMetaDescription($template),
            'meta_keywords_fallback' => $this->buildMetaKeywords($template),
            'noindex' => !$this->buildShouldIndex($template),
            'nofollow' => !$this->buildShouldFollow($template),
            'image_url' => $this->buildImageUrl($template),
            'image_alt' => $this->buildImageAlt($template),
        ]);
        $this->getSeoMetadataTable()->save($seoMetadata);
        return $seoMetadata;
    }

    protected function buildMetaTitle(string $template): ?string
    {
        $method = $this->getConfig('templates.' . $template . '.buildTitleFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_string($method)) return $method;
        return ucfirst(str_replace('/', ' ', mb_strtolower($template)));
    }

    protected function buildMetaDescription(string $template): ?string
    {
        $method = $this->getConfig('templates.' . $template . '.buildDescriptionFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_string($method)) return $method;

        return 'The ' . $this->buildMetaTitle($template) . ' page';
    }

    protected function buildMetaKeywords(string $template): array
    {
        $method = $this->getConfig('templates.' . $template . '.buildKeywordsFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_array($method)) return $method;
        return explode(' ', $this->buildMetaTitle($template));
    }

    protected function buildShouldIndex(string $template): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('templates.' . $template . '.buildShouldIndexFunc');
        if ($method && is_callable($method)) return (bool)$method($template);
        if ($method && is_bool($method)) return $method;
        return true;
    }

    protected function buildShouldFollow(string $template): bool
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('templates.' . $template . '.buildShouldFollowFunc');
        if ($method && is_callable($method)) return (bool)$method($template);
        if ($method && is_bool($method)) return $method;
        return true;
    }

    protected function buildImageUrl(string $template): ?string
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('templates.' . $template . '.buildImageUrlFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_string($method)) return $method;
        return null;
    }

    protected function buildImageAlt(string $template): ?string
    {
        /** @var callable|bool|null $method */
        $method = $this->getConfig('templates.' . $template . '.buildImageAltFunc');
        if ($method && is_callable($method)) return $method($template);
        if ($method && is_string($method)) return $method;
        return null;
    }

    protected function isQualifyingRequest(string $template): bool
    {
        return array_key_exists($template, $this->getConfig('templates'));
    }

    /**
     * @return ServerRequest
     */
    protected function getRequest(): ServerRequest
    {
        return $this->getController()->getRequest();
    }
}
