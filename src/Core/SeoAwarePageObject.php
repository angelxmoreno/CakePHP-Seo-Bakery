<?php

namespace SeoBakery\Core;

use Cake\Routing\Router;
use SeoBakery\Builder\Page;

abstract class SeoAwarePageObject implements SeoAwareInterface
{
    /**
     * returns the template path for the Pages template
     * i.e. /profile/about or /contact
     *
     * @return string
     */
    abstract public function getTemplateName(): string;

    public function buildMetaTitleFallback(string $action): string
    {
        $builder = new Page\MetaTitleBuilder();
        return $builder($this->getTemplateName(), $action);
    }

    public function buildMetaDescriptionFallback(string $action): string
    {
        $builder = new Page\MetaDescriptionBuilder();
        return $builder($this->getTemplateName(), $action);
    }

    public function buildMetaKeywordsFallback(string $action): array
    {
        $builder = new Page\MetaKeywordsBuilder();
        return $builder($this->getTemplateName(), $action);
    }

    public function buildRobotsShouldIndex(string $action): bool
    {
        return true;
    }

    public function buildRobotsShouldFollow(string $action): bool
    {
        return true;
    }

    public function getPrefixPluginControllerArray(): array
    {
        return [
            'prefix' => false,
            'plugin' => false,
            'controller' => 'Pages',
        ];
    }

    public function buildUrl(string $action): string
    {
        $url = $this->getPrefixPluginControllerArray() + ['action' => 'display'] + explode('/', $this->getTemplateName());

        return Router::url($url);
    }

    public function buildImageUrl(string $action): ?string
    {
        return null;
    }

    public function buildImageAlt(string $action): ?string
    {
        return null;
    }

    public function buildSeoName(string $action): string
    {
        return implode(':', [
            'Page',
            trim($this->getTemplateName(), '/'),
        ]);
    }

    public function actions(): array
    {
        return ['display'];
    }
}
