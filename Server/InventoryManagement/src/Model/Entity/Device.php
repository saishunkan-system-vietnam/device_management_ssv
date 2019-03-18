<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Device Entity
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $id_cate
 * @property string $serial_number
 * @property string $product_number
 * @property string $name
 * @property int $brand_id
 * @property string|null $specifications
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $stock_date
 * @property \Cake\I18n\FrozenTime|null $warranty_period
 * @property \Cake\I18n\FrozenTime|null $created_time
 * @property \Cake\I18n\FrozenTime|null $update_time
 * @property bool $is_deleted
 *
 * @property \App\Model\Entity\ParentDevice $parent_device
 * @property \App\Model\Entity\Brand $brand
 * @property \App\Model\Entity\ChildDevice[] $child_devices
 */
class Device extends Entity
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
        'parent_id' => true,
        'id_cate' => true,
        'serial_number' => true,
        'product_number' => true,
        'name' => true,
        'brand_id' => true,
        'specifications' => true,
        'status' => true,
        'stock_date' => true,
        'warranty_period' => true,
        'created_time' => true,
        'update_time' => true,
        'is_deleted' => true,
        'parent_device' => true,
        'brand' => true,
        'child_devices' => true
    ];
}
