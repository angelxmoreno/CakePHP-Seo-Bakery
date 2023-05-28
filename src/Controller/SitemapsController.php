<?php
declare(strict_types=1);

namespace SeoBakery\Controller;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Routing\Router;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;
use Cake\Utility\Xml;
use SeoBakery\Core\SeoAwareEntityTrait;
use SeoBakery\Core\SeoAwareItem;
use SeoBakery\Core\SeoAwareRegistry;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Model\Table\SeoMetadataTable;
use SeoBakery\SeoBakeryPlugin;

/**
 * Sitemaps Controller
 *
 */
class SitemapsController extends AppController
{
    public function index(): Response
    {
        $tableLimit = Configure::read(SeoBakeryPlugin::NAME . '.sitemapTableLimit');
        $xmlArray = [
            'sitemapindex' => [
                'xmlns:' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
                'sitemap' => [],
            ],
        ];

        $seoAwareItems = SeoAwareRegistry::getItems();

        $pages = Hash::get($seoAwareItems, SeoAwareItem::TYPE_PAGE, []);
        if (count($pages) > 0) {
            $uri = sprintf(
                '/sitemaps/sitemap-%s.xml',
                'pages',
            );
            $xmlArray['sitemapindex']['sitemap'][] = ['loc' => Router::url($uri, true)];
        }

        $listViews = Hash::get($seoAwareItems, SeoAwareItem::TYPE_LIST_VIEW, []);
        if (count($listViews) > 0) {
            $uri = sprintf(
                '/sitemaps/sitemap-%s.xml',
                'lists',
            );
            $xmlArray['sitemapindex']['sitemap'][] = ['loc' => Router::url($uri, true)];
        }

        /** @var SeoAwareItem[] $entities */
        $entities = Hash::get($seoAwareItems, SeoAwareItem::TYPE_ENTITY, []);
        foreach ($entities as $item) {
            /** @var SeoAwareEntityTrait $instance */
            $instance = $item->getInstance();
            $table = $instance->getEntityTable();
            $alias = $table->getAlias();
            $count = $this->getSeoMetadataTable()->find()->where([
                'table_alias' => $alias,
                'table_identifier IS NOT' => null,
                'noindex' => false,
            ])->count();
            $pages = ceil($count / $tableLimit);
            for ($page = 1; $page <= $pages; $page++) {
                $uri = sprintf(
                    'sitemaps/sitemap-%s-%s.xml',
                    Inflector::tableize($alias),
                    $page
                );
                $xmlArray['sitemapindex']['sitemap'][] = ['loc' => Router::url($uri, true)];
            }
        }

        return $this->getResponse()
            ->withType('xml')
            ->withStringBody(Xml::fromArray($xmlArray)->asXML());
    }

    public function pages(): Response
    {
        $query = $this->getSeoMetadataTable()->find()->where([
            'controller' => 'Pages',
            'noindex' => false,
        ]);

        return $this->createUrlSet($query);
    }

    public function lists(): Response
    {

        $query = $this->getSeoMetadataTable()->find()->where([
            'controller IS NOT' => 'Pages',
            'table_identifier IS' => null,
            'noindex' => false,
        ]);

        return $this->createUrlSet($query);
    }

    public function entities(string $alias, int $page): Response
    {
        $alias = Inflector::pluralize(Inflector::classify($alias));
        $tableLimit = Configure::read(SeoBakeryPlugin::NAME . '.sitemapTableLimit');
        $query = $this->getSeoMetadataTable()->find()->where([
            'table_alias' => $alias,
            'table_identifier IS NOT' => null,
            'noindex' => false,
        ])->page($page, $tableLimit);
        return $this->createUrlSet($query);
    }

    protected function createUrlSet(Query $query): Response
    {
        $xmlArray = [
            'urlset' => [
                'xmlns:' => 'http://www.sitemaps.org/schemas/sitemap/0.9',
                'url' => [],
            ],
        ];

        /** @var SeoMetadata[] $entities */
        $entities = $query->all();
        foreach ($entities as $entity) {
            $loc = $entity->getCanonicalOrFallback();
            if ($loc) {
                $xmlArray['urlset']['url'][] = [
                    'loc' => Router::url($entity->getCanonicalOrFallback(), true),
                    'lastmod' => $entity->modified->toDateString(),
                ];
            }
        }
        return $this->getResponse()
            ->withType('xml')
            ->withStringBody(Xml::fromArray($xmlArray)->asXML());
    }

    /**
     * @return SeoMetadataTable|Table
     */
    protected function getSeoMetadataTable(): SeoMetadataTable
    {
        return $this->fetchTable(SeoMetadataTable::class);
    }
}
