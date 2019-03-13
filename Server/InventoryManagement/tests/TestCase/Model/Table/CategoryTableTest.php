<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoryTable Test Case
 */
class CategoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoryTable
     */
    public $Category;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Category'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Category') ? [] : ['className' => CategoryTable::class];
        $this->Category = TableRegistry::getTableLocator()->get('Category', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Category);

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
}
