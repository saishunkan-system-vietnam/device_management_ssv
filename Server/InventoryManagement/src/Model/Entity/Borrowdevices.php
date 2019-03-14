<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Borrowdevice Entity
 *
 * @property int $id
 * @property int $borrower_id
 * @property int|null $approved_id
 * @property int|null $handover_id
 * @property int $device_id
 * @property string|null $note
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime $borrow_date
 * @property \Cake\I18n\FrozenTime|null $approved_date
 * @property \Cake\I18n\FrozenTime|null $delivery_date
 * @property \Cake\I18n\FrozenTime $returnee_date
 * @property \Cake\I18n\FrozenTime|null $created_time
 * @property \Cake\I18n\FrozenTime|null $update_time
 * @property bool $is_deleted
 *
 * @property \App\Model\Entity\Borrower $borrower
 * @property \App\Model\Entity\Approved $approved
 * @property \App\Model\Entity\Handover $handover
 * @property \App\Model\Entity\Device $device
 */
class Borrowdevice extends Entity
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
        'borrower_id' => true,
        'approved_id' => true,
        'handover_id' => true,
        'device_id' => true,
        'note' => true,
        'status' => true,
        'borrow_date' => true,
        'approved_date' => true,
        'delivery_date' => true,
        'returnee_date' => true,
        'created_time' => true,
        'update_time' => true,
        'is_deleted' => true,
        'borrower' => true,
        'approved' => true,
        'handover' => true,
        'device' => true
    ];
}
