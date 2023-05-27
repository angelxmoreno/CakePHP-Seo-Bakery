<?php
declare(strict_types=1);

namespace SeoBakery\Test\TestCase\Core;

use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\TestSuite\TestCase;
use SeoBakery\Core\SeoAwareInterface;
use SeoBakery\Shared\StopWords;
use SeoBakery\Test\SeoObjects\Product;

abstract class AbstractSeoAware extends TestCase
{
    /**
     * Test subject
     */
    protected SeoAwareInterface $object;
    protected RouteBuilder $routeBuilder;

    const TABLE_ALIAS = 'Products';
    const ENTITY_CLASS = Product::class;

    public function setUp(): void
    {
        parent::setUp();
        $this->routeBuilder = Router::createRouteBuilder('/');
        $this->routeBuilder->scope('/', function (RouteBuilder $routes) {
            $routes->connect('/pages/*', 'Pages::display');
            $routes->setRouteClass(DashedRoute::class);
            $routes->fallbacks();
        });
        TableRegistry::getTableLocator()->set(static::TABLE_ALIAS, $this->getTableInstance());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->routeBuilder, $this->object);
        TableRegistry::getTableLocator()->remove(static::TABLE_ALIAS);
    }

    protected function getTableInstance(): Table
    {
        $schema = [
            'id' => ['type' => 'integer'],
            'name' => ['type' => 'string'],
            'description' => ['type' => 'string'],
            '_constraints' => [
                'primary' => ['type' => 'primary', 'columns' => ['id']],
            ],
        ];

        $table = new Table([
            'alias' => static::TABLE_ALIAS,
            'schema' => $schema,
            'entityClass' => static::ENTITY_CLASS,
        ]);
        $table->setPrimaryKey('id');
        $table->setDisplayField('name');
        return $table;
    }

    protected function createExpectedKeywords(string $content): array
    {
        $keywords = explode(' ', strtolower($content));
        $keywords = array_unique($keywords);
        $keywords = array_diff($keywords, StopWords::STOP_WORDS);
        return array_map('ucfirst', $keywords);
    }

    abstract public function testBuildMetaTitleFallback(): void;

    abstract public function testBuildMetaDescriptionFallback(): void;

    abstract public function testBuildMetaKeywordsFallback(): void;

    abstract public function testBuildRobotsShouldIndex(): void;

    abstract public function testBuildRobotsShouldFollow(): void;

    abstract public function testGetPrefixPluginControllerArray(): void;

    abstract public function testBuildUrl(): void;
}
