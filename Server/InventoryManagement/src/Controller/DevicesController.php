<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Devices Controller
 *
 *
 * @method \App\Model\Entity\Device[]|\Cake\getDatasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevicesController extends AppController
{
    public $status;
    public $data_name;
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->autoRender = false;
        $this->status = 'success';
        $this->data_name = 'devices';
        $this->loadModel('Files');
    }

    public function index()
    {
        // Only accept POST and GET requests
        $this->request->allowMethod(['post', 'get']);

        if ($this->request->is('post')) {
            $input_data = $this->getRequest()->getData();
        } elseif ($this->request->is('get')) {
            $input_data = $this->getRequest()->getQuery();
        }
        $condition = ['Devices.is_deleted' => 0];
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->find();
        $device_quantity = $devicesTable->find()->select(['count' => 'count(1)']);
        $arr = [];

        if (isset($input_data['id_cate']) && $input_data['id_cate'] != null) {
            array_merge($condition, $arr[] = ['id_cate' => trim($input_data['id_cate'])]);
        }
        if (isset($input_data['serial_number']) && !empty($input_data['serial_number'])) {
            array_merge($condition, $arr[] = ['serial_number LIKE' => '%' . trim($input_data['serial_number']) . '%']);
        }
        if (isset($input_data['product_number']) && !empty($input_data['product_number'])) {
            array_merge($condition, $arr[] = ['product_number LIKE' => '%' . trim($input_data['product_number']) . '%']);
        }
        if (isset($input_data['name']) && !empty($input_data['name'])) {
            array_merge($condition, $arr[] = ['name LIKE' => '%' . trim($input_data['name']) . '%']);
        }
        if (isset($input_data['brand_id']) && $input_data['brand_id'] != null) {
            array_merge($condition, $arr[] = ['brand_id' => trim($input_data['brand_id'])]);
        }
        if (isset($input_data['specifications']) && !empty($input_data['specifications'])) {
            array_merge($condition, $arr[] = ['specifications LIKE' => '%' . trim($input_data['specifications']) . '%']);
        }
        if (isset($input_data['status']) && $input_data['status'] != null) {
            array_merge($condition, $arr[] = ['status' => trim($input_data['status'])]);
        }
        
        $devices->where($condition)->where($arr)
            ->order(['Devices.id' => 'ASC'])
            ->limit($this->perpage)
            ->page($this->page);
        $join = $devices
            ->select([
                'id' => 'Devices.id',
                'name' => 'Devices.name',
                'serial_number' => 'Devices.serial_number',
                'stock_date' => 'Devices.stock_date',
                'warranty_period' => 'Devices.warranty_period',
                'status' => 'Devices.status',
                'path' =>'Files.path',
                'brand_name' => 'Brands.brand_name',
                'brand_id' => 'Brands.id'
            ])
            ->join([
                'Files' => [
                    'table' => 'files',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Files.relate_id = Devices.id'
                    ]
                ]
            ])
            ->join([
                'Brands' => [
                    'table' => 'brands',
                    'type' => 'INNER',
                    'conditions' => [
                        'Brands.id = Devices.brand_id'
                    ]
                ]
            ])
            ->group(['Devices.id']);
            
        $record_all = $device_quantity->where($condition)->where($arr)->first();
        if ($record_all->count == 0 ) {
            $this->status = 'failed';
            $devices = 'Data not found!';
        }
        $this->responseApi($this->status, $this->data_name, $devices, $record_all['count']);
    }

    public function show()
    {
        // Only accept POST and GET requests
        $this->request->allowMethod(['post', 'get']);

        $condition = ['is_deleted' => 0, 'parent_id' => 0];
        $devices = $this->Devices->find();
        $devices_quantity = $this->Devices->find()->select(['count' => 'count(1)']);

        $devices->where($condition)->select(['id','name'])
            ->order(['id' => 'DESC'])
            ->limit($this->perpage)
            ->page($this->page);
        $record_all = $devices_quantity->where($condition)->first();

        $this->responseApi($this->status, $this->data_name, $devices, $record_all['count']);
    }

    public function view()
    {
        $this->request->allowMethod(['post', 'get']);
        //view by id
        $id = $this->request->getParam('id');
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->all();

        if ($devices->count() == 0) {
            $this->status = 'fail';
            $this->data_name = 'message';
            $category = 'Data not found!';
        }
        $this->responseApi($this->status, $this->data_name, $devices);
    }

    public function add()
    {
        // Only accept POST requests
        $this->request->allowMethod(['post']);

        $inputData['parent_id'] = trim($this->getRequest()->getData('parent_id'));
        $inputData['id_parent'] = trim($this->getRequest()->getData('id_parent'));
        $inputData['id_cate'] = trim($this->getRequest()->getData('id_cate'));
        $inputData['serial_number'] = trim($this->getRequest()->getData('serial_number'));
        $inputData['product_number'] = trim($this->getRequest()->getData('product_number'));
        $inputData['name'] = trim($this->getRequest()->getData('name'));
        $inputData['brand_id'] = trim($this->getRequest()->getData('brand_id'));
        $inputData['specifications'] = trim($this->getRequest()->getData('specifications'));
        $inputData['created_user'] = trim($this->getRequest()->getData('created_user'));
        
        //validate
        $devices = $this->Devices->newEntity($inputData);
        
        if ($this->Devices->save($devices)) {
            $device = ['id' => $devices->id];
        } else {
            $this->status = 'failed';
            $this->data_name = 'error';
            $device = $devices->getErrors();
        }
        $this->responseApi($this->status, $this->data_name, $device);
    }

    public function edit()
    {
        //edit
        $this->request->allowMethod(['post']);

        $id = $this->request->getData('id');
        $devices = $this->Devices->get($id);
        //Check exist brand
        if ($devices) {
            $inputData['parent_id'] = trim($this->getRequest()->getData('parent_id'));
            $inputData['id_parent'] = trim($this->getRequest()->getData('id_parent'));
            $inputData['id_cate'] = trim($this->getRequest()->getData('id_cate'));
            $inputData['serial_number'] = trim($this->getRequest()->getData('serial_number'));
            $inputData['product_number'] = trim($this->getRequest()->getData('product_number'));
            $inputData['name'] = trim($this->getRequest()->getData('name'));
            $inputData['brand_id'] = trim($this->getRequest()->getData('brand_id'));
            $inputData['specifications'] = trim($this->getRequest()->getData('specifications'));
            $inputData['status'] = trim($this->getRequest()->getData('status'));
            $inputData['update_user'] = trim($this->getRequest()->getData('update_user'));
            $inputData['is_deleted'] = trim($this->getRequest()->getData('is_deleted'));

            $devices = $this->Devices->patchEntity($devices, $inputData);
            if ($this->Devices->save($devices)) {
                $message = 'Saved!';
            } else {
                $message = $devices->errors();
                $this->status = 'failed';
            }
        } else {
            $this->status = 'failed';
            $this->data_name = 'message';
            $category = 'Data not found!';
        }

        $this->responseApi($this->status, $this->data_name, $devices, $message);
    }

    public function delete()
    {
        $this->request->allowMethod(['post']);
        //delete logic device
        $devices = $this->request->getData();
        $relate_name = $this->getRequest()->getData('relate_name');
        $id = $devices['id'];
        //img
        $path = "img/upload/$relate_name/$id";
        //check
        if ($id != null) {
            $devices = $this->Devices->get($id);
            $devices->is_deleted = 1;
            $devices = $this->Devices->patchEntity($devices, $this->request->getData());
            if ($this->Devices->save($devices)) {
                $this->Files->deleteAll(['relate_id' => $id , 'relate_name' => 'devices']);
                $this->deleteAllFile($path);
                $message = "Deleted!";
            } else {
                $message = "Failed to delete!";
                $this->status = 'failed';
            }
        }else {
            $message = "Please input id to delete device!";
            $this->status = 'failed';
        }
        $this->responseApi($this->status, $this->data_name, $message);
    }

    private function deleteAllFile($str) {
        //It it's a file.
        if (is_file($str)) {
            //Attempt to delete it.
            return unlink($str);
        }
        //If it's a directory.
        elseif (is_dir($str)) {
            //Get a list of the files in this directory.
            $scan = glob(rtrim($str,'/').'/*');
            //Loop through the list of files.
            foreach($scan as $index=>$path) {
                //Call our recursive function.
                $this->deleteAllFile($path);
            }
            //Remove the directory itself.
            return @rmdir($str);
        }
        return true;
    }
}
