<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity
 *
 * @property int $id
 * @property int $relate_id
 * @property string $relate_name
 * @property string $path
 * @property string|null $type
 * @property string|null $created_user
 * @property string|null $update_user
 * @property \Cake\I18n\FrozenTime|null $created_time
 * @property \Cake\I18n\FrozenTime|null $update_time
 * @property bool $is_deleted
 *
 * @property \App\Model\Entity\Relate $relate
 */
class File extends Entity
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
        'relate_id' => true,
        'relate_name' => true,
        'path' => true,
        'type' => true,
        'created_user' => true,
        'update_user' => true,
        'created_time' => true,
        'update_time' => true,
        'is_deleted' => true,
        'relate' => true
    ];
}
