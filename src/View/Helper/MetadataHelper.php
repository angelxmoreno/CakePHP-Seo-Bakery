<?php
declare(strict_types=1);

namespace SeoBakery\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\View;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\SeoBakeryPlugin;
use SeoBakery\Shared\SeoMetadataAware;

/**
 * Metadata helper
 *
 * @property Helper\HtmlHelper $Html
 */
class MetadataHelper extends Helper
{
    use SeoMetadataAware;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];
    protected $helpers = ['Html'];
    protected ?SeoMetadata $seoMetadata;

    public function __construct(View $view, array $config = [])
    {
        $config = array_merge(Configure::read(SeoBakeryPlugin::NAME), $config);
        parent::__construct($view, $config);
    }

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->seoMetadata = $this->getView()->get('seoMetadata');
    }

    public function getSeoMetadata(): SeoMetadata
    {
        if (!$this->seoMetadata) {
            $this->seoMetadata = $this->createMetadataFromRequest();
        }

        return $this->seoMetadata;
    }

    public function afterRender()
    {
        if ($this->seoMetadata) {
            if ($this->seoMetadata->meta_title) {
                $this->getView()->assign('title', $this->seoMetadata->meta_title);
            }
            $dict = [
                'description' => ['meta_description', $this->seoMetadata->meta_description],
                'keywords' => ['meta_keywords', implode(',', $this->seoMetadata->meta_keywords ?? [])],
            ];
            foreach ($dict as $metaName => $args) {
                [$k, $v] = $args;
                if ($this->seoMetadata->has($k)) {
                    $this->Html->meta($metaName, $v, ['block' => true]);
                }
            }
            if ($this->seoMetadata->isDirty()) {
                $this->getSeoMetadataTable()->findOrCreateByRequest($this->seoMetadata->toArray());
            }
        }
    }

    public function setTitle(string $value): self
    {
        $this->getSeoMetadata()->set('meta_title', $value);
        return $this;
    }

    public function setDescription(string $value): self
    {
        $this->getSeoMetadata()->set('meta_description', $value);
        return $this;
    }

    public function setKeywords(array $value): self
    {
        $this->getSeoMetadata()->set('meta_keywords', $value);
        return $this;
    }
}
