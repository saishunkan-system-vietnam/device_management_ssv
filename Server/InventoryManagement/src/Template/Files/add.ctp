<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $file
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Files'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="files form large-9 medium-8 columns content">
    <?= $this->Form->create($file) ?>
    <fieldset>
        <legend><?= __('Add File') ?></legend>
        <?php
            echo $this->Form->control('relate_id');
            echo $this->Form->control('relate_name');
            echo $this->Form->control('path');
            echo $this->Form->control('type');
            echo $this->Form->control('created_time', ['empty' => true]);
            echo $this->Form->control('update_time', ['empty' => true]);
            echo $this->Form->control('is_deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
