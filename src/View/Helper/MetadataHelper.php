<?php

declare(strict_types=1);

namespace SeoBakery\View\Helper;

use Cake\View\Helper;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Shared\SeoMetadataTableAware;

/**
 * Metadata helper
 *
 * @property Helper\HtmlHelper $Html
 */
class MetadataHelper extends Helper
{
    use SeoMetadataTableAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'twitterSiteUsername' => null,
    ];
    protected $helpers = ['Html'];
    protected ?SeoMetadata $seoMetadata;

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->seoMetadata = $this->getView()->get('seoMetadata');
    }

    public function afterRender()
    {
        if ($this->seoMetadata) {
            $this->createMetaTitle();
            $this->createMetaDescription();
            $this->createMetaKeywords();
            $this->createMetaRobots();
            $this->createOpenGraph();
            $this->createTwitterCard();
        }
    }

    protected function createMetaTitle()
    {
        if ($this->seoMetadata->getMetaTitleOrFallback()) {
            $this->getView()->assign('title', $this->seoMetadata->getMetaTitleOrFallback());
        }
    }

    protected function createMetaDescription()
    {
        $this->addToMetaBlock(
            $this->Html->meta(
                'description',
                $this->seoMetadata->getMetaDescriptionOrFallback()
            )
        );
    }

    protected function createMetaKeywords()
    {
        $this->addToMetaBlock(
            $this->Html->meta(
                'keywords',
                implode(',', $this->seoMetadata->getMetaKeywordsOrFallback())
            )
        );
    }

    protected function createMetaRobots()
    {
        $content = '';
        if ($this->seoMetadata->nofollow && $this->seoMetadata->noindex) {
            $content = 'none';
        } elseif (!$this->seoMetadata->nofollow && !$this->seoMetadata->noindex) {
            $content = 'all';
        } elseif ($this->seoMetadata->nofollow && !$this->seoMetadata->noindex) {
            $content = 'nofollow';
        } elseif (!$this->seoMetadata->nofollow && $this->seoMetadata->noindex) {
            $content = 'noindex';
        }
        $this->addToMetaBlock($this->Html->meta('robots', $content));
    }

    protected function createTwitterCard()
    {
        if (!$this->getConfig('twitterSiteUsername')) {
            return;
        }
        $names = [
            'card' => 'summary_large_image',
            'site' => '@' . $this->getConfig('twitterSiteUsername'),
            'title' => $this->seoMetadata->getMetaTitleOrFallback(),
            'description' => $this->seoMetadata->getMetaDescriptionOrFallback(),
        ];

        if ($this->seoMetadata->has('image_url')) {
            $names['image'] = $this->seoMetadata->image_url;
        }

        if ($this->seoMetadata->has('image_alt')) {
            $names['image:alt'] = $this->seoMetadata->image_alt;
        }

        foreach ($names as $name => $content) {
            $this->addToMetaBlock($this->Html->meta('twitter:' . $name, $content));
        }
    }

    protected function createOpenGraph()
    {
        $names = [
            'type' => 'website',// @TODO types should be defined and allowed their subtypes to be defined
            'title' => $this->seoMetadata->getMetaTitleOrFallback(),
            'description' => $this->seoMetadata->getMetaDescriptionOrFallback(),
            'url' => $this->seoMetadata->canonical ?? $this->getView()->getRequest()->getRequestTarget(),
        ];

        if ($siteName = $this->getConfig('siteName')) {
            $names['site_name'] = $siteName;
        }

        if ($this->seoMetadata->has('image_url')) {
            $names['image'] = $this->seoMetadata->image_url;
        }

        foreach ($names as $name => $content) {
            $this->addToMetaBlock($this->Html->tag('meta', null, [
                'property' => 'og:' . $name,
                'content' => $content,
            ]));
        }
    }

    protected function addToMetaBlock(string $tag): void
    {
        $this->getView()->append('meta', "\n" . $tag);
    }
}
