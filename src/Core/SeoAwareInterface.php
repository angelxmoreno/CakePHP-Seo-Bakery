<?php
declare(strict_types=1);

namespace SeoBakery\Core;

interface SeoAwareInterface
{
    public function buildMetaTitleFallback(string $action): string;

    public function buildMetaDescriptionFallback(string $action): string;

    public function buildMetaKeywordsFallback(string $action): array;

    public function buildRobotsShouldIndex(string $action): bool;

    public function buildRobotsShouldFollow(string $action): bool;

    public function getPrefixPluginControllerArray(): array;

    public function buildUrl(string $action): string;

    public function buildImageUrl(string $action): ?string;

    public function buildImageAlt(string $action): ?string;

    public function buildSeoName(string $action): string;

    /**
     * @return string[]
     */
    public function actions(): array;
}
