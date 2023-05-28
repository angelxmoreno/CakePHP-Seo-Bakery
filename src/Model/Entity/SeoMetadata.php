<?php
declare(strict_types=1);

namespace SeoBakery\Model\Entity;

use Cake\I18n\FrozenTime;
use Cake\ORM\Entity;

/**
 * SeoMetadata Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $canonical
 * @property string|null $uri
 * @property string|null $table_alias
 * @property int|null $table_identifier
 * @property string|null $prefix
 * @property string|null $plugin
 * @property string|null $controller
 * @property string|null $action
 * @property array|null $passed
 * @property string|null $meta_title
 * @property string|null $meta_title_fallback
 * @property string|null $meta_description
 * @property string|null $meta_description_fallback
 * @property array|null $meta_keywords
 * @property array|null $meta_keywords_fallback
 * @property bool|null $noindex
 * @property bool|null $nofollow
 * @property string|null $image_url
 * @property string|null $image_alt
 * @property FrozenTime|null $created
 * @property FrozenTime|null $modified
 */
class SeoMetadata extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'name' => true,
        'canonical' => true,
        'uri' => true,
        'table_alias' => true,
        'table_identifier' => true,
        'prefix' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'passed' => true,
        'meta_title' => true,
        'meta_title_fallback' => true,
        'meta_description' => true,
        'meta_description_fallback' => true,
        'meta_keywords' => true,
        'meta_keywords_fallback' => true,
        'noindex' => true,
        'nofollow' => true,
        'image_url' => true,
        'image_alt' => true,
        'created' => true,
        'modified' => true,
    ];

    public function getMetaTitleOrFallback(): ?string
    {
        return $this->meta_title ?? $this->meta_title_fallback;
    }

    public function getMetaDescriptionOrFallback(): ?string
    {
        return $this->meta_description ?? $this->meta_description_fallback;
    }

    public function getMetaKeywordsOrFallback(): ?array
    {
        return $this->meta_keywords ?? $this->meta_keywords_fallback;
    }

    public function getCanonicalOrFallback(): ?string
    {
        return $this->canonical ?? $this->uri;
    }
}
