<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BorrowDevicesDetailFixture
 *
 */
class BorrowDevicesDetailFixture extends TestFixture
{

    /**
     * Table name
     *
     * @var string
     */
    public $table = 'borrow_devices_detail';

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'borrow_device_id' => ['type' => 'biginteger', 'length' => 20, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'borrow_reason' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'return_reason' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'status' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'borrow_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'approved_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'delivery_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'return_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'created_time' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'update_time' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'is_deleted' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'borrow_device_id' => 1,
                'borrow_reason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'return_reason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'status' => 1,
                'borrow_date' => '2019-03-18 10:56:42',
                'approved_date' => '2019-03-18 10:56:42',
                'delivery_date' => '2019-03-18 10:56:42',
                'return_date' => '2019-03-18 10:56:42',
                'created_time' => '2019-03-18 10:56:42',
                'update_time' => '2019-03-18 10:56:42',
                'is_deleted' => 1
            ],
        ];
        parent::init();
    }
}
