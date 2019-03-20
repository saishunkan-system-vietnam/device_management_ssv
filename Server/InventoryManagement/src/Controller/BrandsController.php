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
        $brands = $this->Brands->find();
        $brand_name = trim($this->getRequest()->getData('brand_name'));
        if ($this->request->is('post')) {
            if (!empty($brand_name)) {
                $brands->where(['brand_name Like' => '%' . $brand_name . '%']);
            }
        }
        $brands->where(['is_deleted' => 0]);

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
        $brand = $this->Brands->newEntity();

        if ($this->request->is('post')) {
            $input['brand_name'] = trim($this->request->getData('brand_name'));
            $brand = $this->Brands->patchEntity($brand, $input);
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
                $this->data_name = 'message';
                $brand = 'Save data failed, may be the brand name already exist';
            }

        } else {
            $this->status = 'fail';
            $this->data_name = 'message';
            $brand = 'Not post method';
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
        $id = $this->getRequest()->param('id');
        $data = null;
        $brand = $this->Brands
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->first();
        //Check exist brand
        if ($brand) {
            if ($this->request->is(['patch', 'post', 'put'])) {
                $input['brand_name'] = trim($this->request->getData('brand_name'));
                $input['update_time'] = Time::now();
                $brand = $this->Brands->patchEntity($brand, $input);
                if ($this->Brands->save($brand)) {
                    $data = $this->Brands
                        ->find()
                        ->where([
                            'id' => $id,
                            'is_deleted' => 0,
                        ])->first();
                } else {
                    $this->status = 'fail';
                    $data = 'Save data failed, may be the brand name already exist';
                }
            } else {
                $this->status = 'fail';
                $this->data_name = 'message';
                $data = 'Not post, patch or put method';
            }
        } else {
            $this->data_name = 'message';
            $data = 'Data not found';
        }
        $this->responseApi($this->status, $this->data_name, $data);
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
        $id = $this->getRequest()->getData('id');
        $this->request->allowMethod(['post', 'delete']);

        $brand = $this->Brands
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->first();

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
