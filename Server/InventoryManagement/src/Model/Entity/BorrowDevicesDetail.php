<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BorrowDevicesDetail Entity
 *
 * @property int $id
 * @property int $borrow_device_id
 * @property string|null $borrow_reason
 * @property string|null $return_reason
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime $borrow_date
 * @property \Cake\I18n\FrozenTime|null $approved_date
 * @property \Cake\I18n\FrozenTime|null $delivery_date
 * @property \Cake\I18n\FrozenTime $return_date
 * @property \Cake\I18n\FrozenTime|null $created_time
 * @property \Cake\I18n\FrozenTime|null $update_time
 * @property bool $is_deleted
 *
 * @property \App\Model\Entity\BorrowDevice $borrow_device
 */
class BorrowDevicesDetail extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'borrow_device_id' => true,
        'borrow_reason' => true,
        'return_reason' => true,
        'status' => true,
        'borrow_date' => true,
        'approved_date' => true,
        'delivery_date' => true,
        'return_date' => true,
        'created_time' => true,
        'update_time' => true,
        'is_deleted' => true,
        'borrow_device' => true
    ];
}
