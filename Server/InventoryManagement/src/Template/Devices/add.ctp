<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device $device
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Devices'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="devices form large-9 medium-8 columns content">
    <?= $this->Form->create($device) ?>
    <fieldset>
        <legend><?= __('Add Device') ?></legend>
        <?php
            echo $this->Form->control('parent_id');
            echo $this->Form->control('id_cate');
            echo $this->Form->control('serial_number');
            echo $this->Form->control('product_number');
            echo $this->Form->control('name');
            echo $this->Form->control('brand_id');
            echo $this->Form->control('specifications');
            echo $this->Form->control('status');
            echo $this->Form->control('stock_date', ['empty' => true]);
            echo $this->Form->control('warranty_period', ['empty' => true]);
            echo $this->Form->control('created_time', ['empty' => true]);
            echo $this->Form->control('update_time', ['empty' => true]);
            echo $this->Form->control('is_deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
