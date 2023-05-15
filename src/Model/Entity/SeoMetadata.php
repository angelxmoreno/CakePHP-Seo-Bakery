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
 * @property string $uri
 * @property string|null $canonical
 * @property string|null $table_alias
 * @property int|null $table_identifier
 * @property string|null $prefix
 * @property string|null $plugin
 * @property string|null $controller
 * @property string|null $action
 * @property array|null $passed
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property array|null $meta_keywords
 * @property bool|null $noindex
 * @property bool|null $nofollow
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
        'uri' => true,
        'canonical' => true,
        'table_alias' => true,
        'table_identifier' => true,
        'prefix' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'passed' => true,
        'meta_title' => true,
        'meta_description' => true,
        'meta_keywords' => true,
        'noindex' => true,
        'nofollow' => true,
        'created' => true,
        'modified' => true,
    ];
}