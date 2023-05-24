<?php
/**
 * @var AppView $this
 * @var SeoMetadata $seoMetadata
 */

use App\View\AppView;
use SeoBakery\Model\Entity\SeoMetadata;

$this->Html->css(['SeoBakery.bs5-scoped'], ['block' => true]);

?>
<div class="bs5-scoped">
    <div class="container">
        <div class="row">
            <aside class="col-md-2">
                <h4 class="heading"><?= __('Actions') ?></h4>
                <nav class="nav nav-pills flex-column">
                    <?= $this->Html->link(__('Edit Metadata'), ['action' => 'edit', $seoMetadata->id], ['class' => 'nav-link']) ?>
                    <?= $this->Form->postLink(__('Delete Metadata'), ['action' => 'delete', $seoMetadata->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoMetadata->id), 'class' => 'nav-link']) ?>
                    <?= $this->Html->link(__('List Metadata'), ['action' => 'index'], ['class' => 'nav-link']) ?>
                </nav>
            </aside>
            <div class="col">
                <div class="seoMetadata view content">
                    <h3><?= h($seoMetadata->name) ?></h3>
                    <table class="table">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <td><?= $this->Number->format($seoMetadata->id) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Canonical') ?></th>
                            <td><?= h($seoMetadata->canonical) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Table Alias') ?></th>
                            <td><?= h($seoMetadata->table_alias) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Table Identifier') ?></th>
                            <td><?= $seoMetadata->table_identifier === null ? '' : $this->Number->format($seoMetadata->table_identifier) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Prefix') ?></th>
                            <td><?= h($seoMetadata->prefix) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Plugin') ?></th>
                            <td><?= h($seoMetadata->plugin) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Controller') ?></th>
                            <td><?= h($seoMetadata->controller) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Action') ?></th>
                            <td><?= h($seoMetadata->action) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Passed') ?></th>
                            <td><?= !!$seoMetadata->passed ? implode(',', $seoMetadata->passed) : ''; ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Meta Title') ?></th>
                            <td><?= h($seoMetadata->meta_title) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Meta Title Fallback') ?></th>
                            <td><?= h($seoMetadata->meta_title_fallback) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Meta Description') ?></th>
                            <td><?= h($seoMetadata->meta_description) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Meta Description Fallback') ?></th>
                            <td><?= h($seoMetadata->meta_description_fallback) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Meta Keywords') ?></th>
                            <td><?= !!$seoMetadata->meta_keywords ? implode(',', $seoMetadata->meta_keywords) : '' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Meta Keywords Fallback') ?></th>
                            <td><?= !!$seoMetadata->meta_keywords_fallback ? implode(',', $seoMetadata->meta_keywords_fallback) : '' ?></td>
                        </tr>


                        <tr>
                            <th><?= __('Noindex') ?></th>
                            <td><?= $seoMetadata->noindex ? __('Yes') : __('No'); ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Nofollow') ?></th>
                            <td><?= $seoMetadata->nofollow ? __('Yes') : __('No'); ?></td>
                        </tr>

                        <tr>
                            <th><?= __('Image Alt') ?></th>
                            <td><?= h($seoMetadata->image_alt) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Image') ?></th>
                            <td><?= !!$seoMetadata->image_url ? $this->Html->image($seoMetadata->image_url) : '' ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Created') ?></th>
                            <td><?= h($seoMetadata->created) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Modified') ?></th>
                            <td><?= h($seoMetadata->modified) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
