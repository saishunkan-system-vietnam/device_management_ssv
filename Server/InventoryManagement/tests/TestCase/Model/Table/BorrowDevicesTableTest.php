<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BorrowDevicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BorrowDevicesTable Test Case
 */
class BorrowDevicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BorrowDevicesTable
     */
    public $BorrowDevices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.BorrowDevices',
        'app.Borrowers',
        'app.Approveds',
        'app.Handovers',
        'app.Devices',
        'app.BorrowDevicesDetail'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('BorrowDevices') ? [] : ['className' => BorrowDevicesTable::class];
        $this->BorrowDevices = TableRegistry::getTableLocator()->get('BorrowDevices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->BorrowDevices);

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
