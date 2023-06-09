<?php

declare(strict_types=1);

namespace SeoBakery;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;

/**
 * Plugin for SeoBakery
 */
class SeoBakeryPlugin extends BasePlugin
{
    public const NAME = 'SeoBakery';

    public static function buildBehaviorConfigs(array $rawConfig): array
    {
        $models = [];
        foreach ($rawConfig['behaviorModels'] as $k => $v) {
            $alias = is_string($v) ? $v : $k;
            $config = is_string($v) ? [] : $v;
            $config = array_merge([
                'actions' => ['view'],
                'identifierFunc' => 0,
            ], $config);
            $models[$alias] = $config;
        }

        return $models;
    }

    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        parent::bootstrap($app);
    }

    /**
     * Add routes for the plugin.
     *
     * If your plugin has many routes and you would like to isolate them into a separate file,
     * you can create `$plugin/config/routes.php` and delete this method.
     *
     * @param RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes(RouteBuilder $routes): void
    {
        $robotsPath = Configure::read(self::NAME . '.robotsPath');
        $sitemapIndexPath = Configure::read(self::NAME . '.sitemapIndexPath');
        $routes->connect($robotsPath, [
            'prefix' => false,
            'plugin' => 'SeoBakery',
            'controller' => 'Robots',
            'action' => 'display',
        ]);

        $routes->connect($sitemapIndexPath, [
            'prefix' => false,
            'plugin' => 'SeoBakery',
            'controller' => 'Sitemaps',
            'action' => 'index',
        ]);

        $routes->connect('/sitemaps/sitemap-{alias}-{page}.xml', [
            'prefix' => false,
            'plugin' => 'SeoBakery',
            'controller' => 'Sitemaps',
            'action' => 'entities',
        ])
            ->setPatterns(['page' => '\d+'])
            ->setPass(['alias', 'page']);

        $routes->connect('/sitemaps/sitemap-{action}.xml', [
            'prefix' => false,
            'plugin' => 'SeoBakery',
            'controller' => 'Sitemaps',
        ]);

        $routes->plugin(
            'SeoBakery',
            ['path' => '/seo-bakery'],
            function (RouteBuilder $builder) {
                // Add custom routes here

                $builder->fallbacks();
            }
        );
        parent::routes($routes);
    }

    /**
     * Add middleware for the plugin.
     *
     * @param MiddlewareQueue $middlewareQueue The middleware queue to update.
     * @return MiddlewareQueue
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        return $middlewareQueue;
    }

    /**
     * Add commands for the plugin.
     *
     * @param CommandCollection $commands The command collection to update.
     * @return CommandCollection
     */
    public function console(CommandCollection $commands): CommandCollection
    {
        return parent::console($commands);
    }
}
