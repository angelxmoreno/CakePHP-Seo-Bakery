<?php

declare(strict_types=1);

namespace SeoBakery\View\Helper;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Table;
use Cake\Utility\Inflector;
use Cake\View\Helper;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\Model\Table\SeoMetadataTable;

/**
 * Dashboard helper
 *
 * @property-read Helper\HtmlHelper $Html
 * @property-read Helper\FormHelper $Form
 */
class DashboardHelper extends Helper
{
    use LocatorAwareTrait;

    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [
        'tableBuilder' => [],
    ];
    protected $helpers = ['Html', 'Form'];

    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setConfig('tableBuilder', [
            'name',
            'canonical',
            'displayed' => function (SeoMetadata $entity) {
                return implode("\n", [
                    $this->Html->tag('strong', $entity->getMetaTitleOrFallback()),
                    '<br/>',
                    $this->Html->tag('i', $entity->getMetaDescriptionOrFallback()),
                ]);
            },
            'actual' => function (SeoMetadata $entity) {
                return implode("\n", [
                    $this->Html->tag('strong', $entity->meta_title),
                    '<br/>',
                    $this->Html->tag('i', $entity->meta_description),
                ]);
            },
            'actions' => function (SeoMetadata $entity) {
                return $this->Html->div('', implode("\n", [
                    $this->Html->link(__('View'), ['action' => 'view', $entity->id], [
                        'class' => 'btn btn-sm btn-primary',
                    ]),
                    $this->Html->link(__('Edit'), ['action' => 'edit', $entity->id], [
                        'class' => 'btn btn-sm btn-info',
                    ]),
                    $this->Form->postLink(__('Delete'), ['action' => 'delete', $entity->id], [
                        'class' => 'btn btn-sm btn-danger',
                        'confirm' => __('Are you sure you want to delete # {0}?', $entity->id),
                    ]),
                ]));
            },
        ]);
    }

    /**
     * @param SeoMetadata[] $entities
     * @param array $options
     * @return string
     */
    public function renderTable(array $entities, array $options = []): string
    {
        $options = array_merge([
            'containerClass' => 'table-responsive',
            'tableBuilder' => $this->getConfig('tableBuilder'),
            'tableClass' => 'table table-striped table-hover table-bordered',
        ], $options);

        $headers = [];
        $cellRenderers = [];
        $rows = [];
        foreach ($options['tableBuilder'] as $name => $cellRender) {
            if (is_string($cellRender) && is_int($name)) {
                $headers[] = Inflector::humanize($cellRender);
                $cellRenderers[] = fn(SeoMetadata $entity) => $entity->get($cellRender);
            } elseif (is_callable($cellRender) && is_string($name)) {
                $headers[] = Inflector::humanize($name);
                $cellRenderers[] = $cellRender;
            }
        }

        foreach ($entities as $rowIndex => $entity) {
            foreach ($cellRenderers as $cellRenderer) {
                $rows[$rowIndex][] = $cellRenderer($entity);
            }
        }

        $tableHeader = $this->Html->tag('thead', $this->Html->tableHeaders($headers));
        $tableBody = $this->Html->tag('tbody', $this->Html->tableCells($rows));
        $table = $this->Html->tag('table', $tableHeader . $tableBody, [
            'class' => $options['tableClass'],
        ]);
        return $this->Html->div($options['containerClass'], $table);
    }

    public function tableAliasFilter(): string
    {
        $this->Html->script('SeoBakery.selectJumpUrl', ['block' => true]);
        $tableAliases = $this->getTable()->fetchUniqueTableAliasList();
        return $this->dropdown('table_alias', $tableAliases);
    }

    public function missingFieldsFilter(): string
    {
        $this->Html->script('SeoBakery.selectJumpUrl', ['block' => true]);
        $fields = SeoMetadataTable::MISSING_FIELDS_OPTIONS;
        $options = array_combine($fields, $fields);
        $options = [0 => '----'] + $options;
        return $this->dropdown('missing', $options);
    }

    public function optimizedFilter(): string
    {
        $this->Html->script('SeoBakery.selectJumpUrl', ['block' => true]);
        $fields = SeoMetadataTable::OPTIMIZED_OPTIONS;
        $options = array_combine($fields, $fields);
        $options = [0 => '----'] + $options;
        return $this->dropdown('optimized', $options);
    }

    public function sortDropDown(): string
    {
        return $this->sortFieldDropDown() . $this->sortDirectionDropDown();
    }

    public function sortFieldDropDown(): string
    {
        $this->Html->script('SeoBakery.selectJumpUrl', ['block' => true]);
        $fields = SeoMetadataTable::SORT_FIELDS_OPTIONS;
        $options = array_combine($fields, $fields);
        $options = [0 => '----'] + $options;
        return $this->dropdown('sort', $options);
    }

    public function sortDirectionDropDown(): string
    {
        $this->Html->script('SeoBakery.selectJumpUrl', ['block' => true]);
        $options = [
            'asc' => 'Ascending',
            'desc' => 'Descending',
        ];
        return $this->dropdown('direction', $options);
    }

    public function statusFilter(): string
    {
        $statuses = [
            0 => 'All',
            1 => 'Missing Fields',
            2 => 'Completed',
        ];
        return $this->dropdown('status', $statuses);
    }

    protected function dropdown(string $name, array $options, array $config = []): string
    {
        $config = array_merge([
            'value' => $this->getView()->getRequest()->getQuery($name),
            'container' => [
                'class' => 'input-group col',
            ],
            'label' => [
                'class' => 'input-group-text mb-0',
            ],
            'options' => $options,
            'class' => 'form-select select-jump-url',
        ], $config);

        return $this->Form->control($name, $config);
    }

    /**
     * @return SeoMetadataTable|Table
     */
    protected function getTable(): SeoMetadataTable
    {
        return $this->fetchTable(SeoMetadataTable::class);
    }
}
