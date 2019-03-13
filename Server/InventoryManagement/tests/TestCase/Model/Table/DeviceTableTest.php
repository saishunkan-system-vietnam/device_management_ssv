<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DeviceTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DeviceTable Test Case
 */
class DeviceTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DeviceTable
     */
    public $Device;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Device',
        'app.Brands',
        'app.Borrowdevice'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Device') ? [] : ['className' => DeviceTable::class];
        $this->Device = TableRegistry::getTableLocator()->get('Device', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Device);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
