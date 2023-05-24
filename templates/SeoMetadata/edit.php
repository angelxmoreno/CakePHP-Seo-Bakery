<?php
/**
 * @var AppView $this
 * @var SeoMetadata $seoMetadata
 */

use App\View\AppView;
use SeoBakery\Model\Entity\SeoMetadata;

?>
<div class="bs5-scoped">
    <div class="container">
        <div class="row">
            <aside class="col-md-2">
                <h4 class="heading"><?= __('Actions') ?></h4>
                <nav class="nav nav-pills flex-column">
                    <?= $this->Html->link(__('View Metadata'), ['action' => 'view', $seoMetadata->id], ['class' => 'nav-link']) ?>
                    <?= $this->Form->postLink(__('Delete Metadata'), ['action' => 'delete', $seoMetadata->id], ['confirm' => __('Are you sure you want to delete # {0}?', $seoMetadata->id), 'class' => 'nav-link']) ?>
                    <?= $this->Html->link(__('List Metadata'), ['action' => 'index'], ['class' => 'nav-link']) ?>
                </nav>
            </aside>
            <div class="col">
                <div class="seoMetadata view content">
                    <h3>Edit Seo Metadata for <?= $seoMetadata->name ?></h3>
                    <?= $this->Form->create($seoMetadata) ?>
                    <?php
                    echo $this->Form->control('canonical');
                    echo $this->Form->control('meta_title', [
                        'help' => sprintf('Fallback: <strong>%s</strong>', $seoMetadata->meta_title_fallback),
                    ]);
                    echo $this->Form->control('meta_description', [
                        'help' => sprintf('Fallback: <strong>%s</strong>', $seoMetadata->meta_description_fallback),
                    ]);
                    echo $this->Form->control('meta_keywords', [
                        'help' => sprintf('Fallback: <strong>%s</strong>', implode(',', $seoMetadata->meta_keywords_fallback)),
                    ]);
                    echo $this->Form->control('noindex');
                    echo $this->Form->control('nofollow');
                    echo $this->Form->control('image_alt', ['type' => 'text']);
                    echo $this->Form->control('image_url');
                    ?>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
