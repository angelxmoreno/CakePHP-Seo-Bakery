<?php

declare(strict_types=1);

namespace SeoBakery\Test\SeoObjects;

use SeoBakery\Core\SeoAwareInterface;

class BadSeoAwareObj implements SeoAwareInterface
{
    public function buildMetaTitleFallback(string $action): string
    {
        // TODO: Implement buildMetaTitleFallback() method.
    }

    public function buildMetaDescriptionFallback(string $action): string
    {
        // TODO: Implement buildMetaDescriptionFallback() method.
    }

    public function buildMetaKeywordsFallback(string $action): array
    {
        // TODO: Implement buildMetaKeywordsFallback() method.
    }

    public function buildRobotsShouldIndex(string $action): bool
    {
        // TODO: Implement buildRobotsShouldIndex() method.
    }

    public function buildRobotsShouldFollow(string $action): bool
    {
        // TODO: Implement buildRobotsShouldFollow() method.
    }

    public function getPrefixPluginControllerArray(): array
    {
        // TODO: Implement getPrefixPluginControllerArray() method.
    }

    public function buildUrl(string $action): string
    {
        // TODO: Implement buildUrl() method.
    }

    public function buildImageUrl(string $action): ?string
    {
        // TODO: Implement buildImageUrl() method.
    }

    public function buildImageAlt(string $action): ?string
    {
        // TODO: Implement buildImageAlt() method.
    }

    public function buildSeoName(string $action): string
    {
        // TODO: Implement buildSeoName() method.
    }

    /**
     * @inheritDoc
     */
    public function actions(): array
    {
        // TODO: Implement actions() method.
    }
}
