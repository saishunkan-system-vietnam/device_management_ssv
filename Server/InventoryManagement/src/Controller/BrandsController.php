<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Brands Controller
 *
 *
 * @method \App\Model\Entity\Brand[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BrandsController extends AppController
{

    /**
     *  Status result api
     */
    public $status;

    /**
     *  Data Name Table result or Message
     */
    public $data_name;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->autoRender = false;
        $this->status = 'success';
        $this->data_name = 'brands';

        $this->loadModel('Devices');

    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        // Only accept POST and GET requests
        $this->request->allowMethod(['post', 'get']);

        if ($this->request->is('post')) {
            $inputData = $this->getRequest()->getData();

        } elseif ($this->request->is('get')) {
            $inputData = $this->getRequest()->getQuery();
        }

        $brands = $this->Brands->find();
        if (isset($inputData['brand_name']) && !empty($inputData['brand_name'])) {
            $brands->where(['brand_name Like' => '%' . trim($inputData['brand_name']) . '%']);
        }
        $brands->where(['is_deleted' => 0]);
        $brands->limit($this->perpage)
            ->page($this->page);

        $this->responseApi($this->status, $this->data_name, $brands);
    }

    /**
     * View method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $id = $this->getRequest()->param('id');

        $brand = $this->Brands
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->all();

        if ($brand->count() == 0) {
            $this->data_name = 'message';
            $brand = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $brand);

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // Only accept POST requests
        $this->request->allowMethod(['post']);

        $inputData['brand_name'] = trim($this->request->getData('brand_name'));
        $inputData['created_user'] = 'zin';
        $brand = $this->Brands->newEntity();
        $brand = $this->Brands->patchEntity($brand, $inputData);
        if ($data = $this->Brands->save($brand)) {
            $id = $data->id;
            $brand = $this->Brands
                ->find()
                ->where([
                    'id' => $id,
                    'is_deleted' => 0,
                ])->all();
        } else {
            $this->status = 'fail';
            $this->data_name = 'error';
            $category = $category->errors();
        }

        $this->responseApi($this->status, $this->data_name, $brand);
    }

    /**
     * Edit method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Only accept PATCH POST and PUT requests
        $this->request->allowMethod(['patch', 'post', 'put']);

        $id = $this->getRequest()->param('id');

        $brand = $this->Brands
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->first();
        //Check exist brand
        if ($brand) {
            $inputData['brand_name'] = trim($this->request->getData('brand_name'));
            $inputData['update_user'] = 'zin';
            $inputData['update_time'] = Time::now();
            $brand = $this->Brands->patchEntity($brand, $inputData);
            if ($this->Brands->save($brand)) {
                $brand = $this->Brands
                    ->find()
                    ->where([
                        'id' => $id,
                        'is_deleted' => 0,
                    ])->first();
            } else {
                $this->status = 'fail';
                $this->data_name = 'error';
                $category = $category->errors();
            }
        } else {
            $this->data_name = 'message';
            $brand = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $brand);
    }

    /**
     * Delete method
     *
     * @param string|null $id Brand id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // Only accept POST and GET requests
        $this->request->allowMethod(['delete', 'post']);

        $id = $this->getRequest()->param('id');

        $brand = $this->Brands
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->first();
        //Check exist brand
        if ($brand) {
            $devices = $this->Devices->find()
                ->where([
                    'brand_id' => $id,
                    'is_deleted' => 0,
                ])
                ->all();
            // Check there are device that are using brand
            if ($devices->count() == 0) {
                $brand->is_deleted = (int) 1;
                $category->update_user = 'zin';
                $brand->update_time = Time::now();
                if ($this->Brands->save($brand)) {
                    $data_name = 'message';
                    $data = 'Delete data successfully';
                } else {
                    $this->status = 'fail';
                    $this->data_name = 'message';
                    $data = 'Delete data failed';
                }
            } else {
                $data_name = 'message';
                $data = 'Cant not delete. There are device that are using this brand yet to be deleted ';
            }
        } else {
            $data_name = 'message';
            $data = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $data);
    }
}
