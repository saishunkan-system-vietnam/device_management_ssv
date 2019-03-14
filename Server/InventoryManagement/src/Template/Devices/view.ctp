<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Device $device
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Device'), ['action' => 'edit', $device->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Device'), ['action' => 'delete', $device->id], ['confirm' => __('Are you sure you want to delete # {0}?', $device->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Devices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Device'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="devices view large-9 medium-8 columns content">
    <h3><?= h($device->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Serial Number') ?></th>
            <td><?= h($device->serial_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Product Number') ?></th>
            <td><?= h($device->product_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($device->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($device->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Id') ?></th>
            <td><?= $this->Number->format($device->parent_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id Cate') ?></th>
            <td><?= $this->Number->format($device->id_cate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Brand Id') ?></th>
            <td><?= $this->Number->format($device->brand_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($device->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stock Date') ?></th>
            <td><?= h($device->stock_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Warranty Period') ?></th>
            <td><?= h($device->warranty_period) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Time') ?></th>
            <td><?= h($device->created_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Update Time') ?></th>
            <td><?= h($device->update_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $device->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Specifications') ?></h4>
        <?= $this->Text->autoParagraph(h($device->specifications)); ?>
    </div>
</div>
