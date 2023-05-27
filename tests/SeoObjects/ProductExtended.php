<?php
declare(strict_types=1);

namespace SeoBakery\Test\SeoObjects;

use Cake\Utility\Inflector;
use SeoBakery\Core\SeoAwareEntityTrait;
use SeoBakery\Core\SeoAwareInterface;

class ProductExtended extends Product implements SeoAwareInterface
{
    use SeoAwareEntityTrait;

    public function buildMetaTitleFallback(string $action): string
    {
        return $this->name . ' Extended';
    }

    public function buildMetaDescriptionFallback(string $action): string
    {
        return 'Extended ' . $this->description;
    }

    public function buildMetaKeywordsFallback(string $action): array
    {
        return [$this->name, $this->description, 'Extended'];
    }

    public function buildRobotsShouldIndex(string $action): bool
    {
        return false;
    }

    public function buildRobotsShouldFollow(string $action): bool
    {
        return false;
    }

    public function getPrefixPluginControllerArray(): array
    {
        return [
            'prefix' => false,
            'plugin' => 'Store',
            'controller' => 'Items',
        ];
    }

    public function buildUrl(string $action): string
    {
        return '/store/item/' . Inflector::variable($this->name);
    }
}
