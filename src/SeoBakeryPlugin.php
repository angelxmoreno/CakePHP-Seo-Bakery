<?php
declare(strict_types=1);

namespace SeoBakery;

use Cake\Console\CommandCollection;
use Cake\Core\BasePlugin;
use Cake\Core\ContainerInterface;
use Cake\Core\PluginApplicationInterface;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\RouteBuilder;
use Cake\Utility\Hash;

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
            $config = is_string($v) ? [
                'prefix' => null,
                'plugin' => null,
                'controller' => $alias,
                'actions' => ['view'],
            ] : $v;

            $models[$alias] = $config;
        }

        return $models;
    }

    public static function buildComponentConfigs(array $behaviorConfigs): array
    {
        $controllers = [];
        foreach ($behaviorConfigs as $k => $v) {
            $name = Hash::get($v, 'controller');
            $controllers[$name] = $v;
            $controllers[$name]['model'] = $k;
        }
        return $controllers;
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
        // Add your middlewares here

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
        // Add your commands here

        $commands = parent::console($commands);

        return $commands;
    }

    /**
     * Register application container services.
     *
     * @param ContainerInterface $container The Container to update.
     * @return void
     * @link https://book.cakephp.org/4/en/development/dependency-injection.html#dependency-injection
     */
    public function services(ContainerInterface $container): void
    {
        // Add your services here
    }
}
