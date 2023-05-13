<?php
declare(strict_types=1);

namespace SeoBakery\Model\Entity;

use Cake\ORM\Entity;

/**
 * SeoMetadata Entity
 *
 * @property int $id
 * @property string $url
 * @property string|null $canonical
 * @property string|null $entity_class
 * @property int|null $entity_identifier
 * @property string|null $prefix
 * @property string|null $plugin
 * @property string|null $controller
 * @property string|null $action
 * @property string|null $passed
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @property bool|null $noindex
 * @property bool|null $nofollow
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
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
        'url' => true,
        'canonical' => true,
        'entity_class' => true,
        'entity_identifier' => true,
        'prefix' => true,
        'plugin' => true,
        'controller' => true,
        'action' => true,
        'passed' => true,
        'title' => true,
        'description' => true,
        'keywords' => true,
        'noindex' => true,
        'nofollow' => true,
        'created' => true,
        'modified' => true,
    ];
}
