<?php

/**
 * @var AppView $this
 * @var iterable<SeoMetadata>|ResultSetInterface $seoMetadata
 * @var array $tableAliases
 */

use Cake\Datasource\ResultSetInterface;
use SeoBakery\Model\Entity\SeoMetadata;
use SeoBakery\View\AppView;

$this->Html->css(['SeoBakery.bs5-scoped'], ['block' => true]);

?>
<div class="bs5-scoped">
    <div class="container">
        <h3><?= __('Seo Metadata') ?></h3>
        <div class="row">
            <?= $this->Dashboard->tableAliasFilter() ?>
            <?= $this->Dashboard->missingFieldsFilter() ?>
            <?= $this->Dashboard->optimizedFilter() ?>
            <?= $this->Dashboard->sortDropDown() ?>
        </div>
        <?php if ($seoMetadata->count() > 0) : ?>
            <p class="border-start-0 border-end-0 border pt-2 mt-2 pb-2 mb-2">
                <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
            </p>
        <?php endif; ?>
        <?php if ($seoMetadata->count() > 0) : ?>
            <?= $this->Dashboard->renderTable($seoMetadata->toArray()) ?>
        <?php else : ?>
            <p class="lead">No SEO metadata entries found.</p>
        <?php endif; ?>
        <?php if ($seoMetadata->count() > 0) : ?>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
