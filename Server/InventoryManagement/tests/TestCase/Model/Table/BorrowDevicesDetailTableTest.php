<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BorrowDevicesDetailTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BorrowDevicesDetailTable Test Case
 */
class BorrowDevicesDetailTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BorrowDevicesDetailTable
     */
    public $BorrowDevicesDetail;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.BorrowDevicesDetail',
        'app.BorrowDevices',
        'app.Devices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BorrowDevicesDetail') ? [] : ['className' => BorrowDevicesDetailTable::class];
        $this->BorrowDevicesDetail = TableRegistry::getTableLocator()->get('BorrowDevicesDetail', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BorrowDevicesDetail);

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
