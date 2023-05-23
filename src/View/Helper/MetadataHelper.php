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
    protected $_defaultConfig = [];
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
        }
    }

    protected function createMetaTitle()
    {
        if ($this->seoMetadata->getMetaTitleOrFallback()) {
            $this->getView()->assign('title', $this->seoMetadata->getMetaTitleOrFallback);
        }
    }

    protected function createMetaDescription()
    {
        $this->Html->meta('description', $this->seoMetadata->getMetaDescriptionOrFallback(), ['block' => true]);
    }

    protected function createMetaKeywords()
    {
        $this->Html->meta('keywords', implode(',', $this->seoMetadata->getMetaKeywordsOrFallback()), ['block' => true]);
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
        $this->Html->meta('robots', $content, ['block' => true]);
    }
}
