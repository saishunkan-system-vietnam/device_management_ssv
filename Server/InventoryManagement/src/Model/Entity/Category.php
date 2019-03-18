<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property int|null $id_parent
 * @property string $category_name
 * @property \Cake\I18n\FrozenTime|null $created_time
 * @property \Cake\I18n\FrozenTime|null $update_time
 * @property bool $is_deleted
 */
class Category extends Entity
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
        'id_parent' => true,
        'category_name' => true,
        'created_time' => true,
        'update_time' => true,
        'is_deleted' => true
    ];
}
