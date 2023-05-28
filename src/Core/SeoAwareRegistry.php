<?php

declare(strict_types=1);

namespace SeoBakery\Core;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use SeoBakery\Model\Behavior\MetadataBehavior;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Model\Table\SeoMetadataTable;

class SeoAwareRegistry
{
    /**
     * @var SeoAwareItem[][]
     */
    public static array $objects = [];

    public static function scan()
    {
        $path = current(App::classPath('Seo'));
        $suffix = '*Object.php';
        $classPaths = glob($path . $suffix);
        array_map(function (string $classPath) use ($path, $suffix) {
            $fileName = str_replace($path, '', $classPath);
            $className = str_replace('.php', '', $fileName);
            $shortClassname = str_replace('/', '\\', $className);
            $fullClassname = Configure::read('App.namespace') . '\\Seo\\' . $shortClassname;

            /** @var SeoAwareInterface $instance */
            $instance = new $fullClassname();
            self::add($instance);
        }, $classPaths);
    }

    public static function add(SeoAwareInterface $instance)
    {
        $route = $instance->getPrefixPluginControllerArray();
        $key = self::keyFromRouteArray($route);
        self::$objects[$key] = self::$objects[$key] ?? [];
        self::$objects[$key][] = new SeoAwareItem($instance);
    }

    public static function getFromRequest(ServerRequest $request): ?SeoMetadata
    {
        $attrs = $request->getAttributes();
        $action = $attrs['params']['action'];
        $pass = $attrs['params']['pass'];
        $key = self::keyFromRouteArray($attrs['params']);
        $group = self::$objects[$key] ?? null;
        if (is_null($group)) {
            return null;
        }
        foreach ($group as $seoAwareItem) {
            if (in_array($action, $seoAwareItem->getActions())) {
                $type = $seoAwareItem->getType();
                if ($type === SeoAwareItem::TYPE_PAGE) {
                    /** @var SeoAwarePageObject|SeoAwareInterface $instance */
                    $instance = $seoAwareItem->getInstance();

                    $passString = implode('/', $pass);
                    $template = trim($instance->getTemplateName(), '/');
                    if ($passString === $template) {
                        return self::getSeoMetadataTable()->fromSeoAwareObj($instance, $action);
                    }
                } elseif ($type === SeoAwareItem::TYPE_ENTITY) {
                    /** @var SeoAwareEntityTrait $instance */
                    $instance = $seoAwareItem->getInstance();
                    /** @var Table&MetadataBehavior $table */
                    $table = $instance->getEntityTable();
                    return $table->fetchMetaDataByRequest(compact('request'));
                }
                return self::getSeoMetadataTable()->fromSeoAwareObj($seoAwareItem->getInstance(), $action);
            }
        }
        return null;
    }

    /**
     * @return SeoAwareItem[]
     */
    public static function getItems(): array
    {
        $items = [];
        foreach (self::$objects as $group) {
            foreach ($group as $item) {
                $items[$item->getType()] = $items[$item->getType()] ?? [];
                $items[$item->getType()][] = $item;
            }
        }

        return $items;
    }

    protected static function keyFromRouteArray(array $route): string
    {
        return sprintf('%s:%s:%s', $route['prefix'] ?? null, $route['plugin'], $route['controller']);
    }

    /**
     * @return SeoMetadataTable|Table
     */
    protected static function getSeoMetadataTable(): SeoMetadataTable
    {
        return TableRegistry::getTableLocator()->get(SeoMetadataTable::class);
    }
}
