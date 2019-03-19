<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Filesystem\Folder;
use Cake\View\Helper\FlashHelper;
use Cake\Validation\Validator;

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
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->find('all');
        $this->responseApi($this->status,$this->data_name,$devices);
    }

    public function view($id)
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->where(['id'=>$id])->first();
        $this->responseApi($this->status,$this->data_name,$devices);
        // $this->payload['payload']['categories'] = $devices;
        // $this->response->body(json_encode($this->payload));
        
    }

    public function add()
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->newEntity();
        if($this->request->is('post')){
            $devices->parent_id = $this->request->getData('parent_id');
            $devices->id_cate = $this->request->getData('id_cate');
            $devices->serial_number = $this->request->getData('serial_number');
            $devices->product_number = $this->request->getData('product_number');
            $devices->name = $this->request->getData('name');
            $devices->brand_id = $this->request->getData('brand_id');
            $devices->specifications = $this->request->getData('specifications');
            $devices->status = $this->request->getData('status');
            $devices->warranty_period = $this->request->getData('warranty_period');  
            $devices->created_time = $this->request->getData('created_time'); 
            $devices->update_time = $this->request->getData('update_time'); 
            $devices->is_deleted = $this->request->getData('is_deleted'); 

            $devices = $this->Devices->patchEntity($devices, $this->request->getData());
            
            if ($this->Devices->save($devices)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        $this->responseApi($this->status,$this->data_name,$message);
    }

    public function addImage()
    {   
        $devicesTable = TableRegistry::get('Devices');
        $devices = $this->request->getData();
        $id = $devices['id'];
        $filesTable = TableRegistry::get('Files');
        $images = $this->request->getData();
        $folderPath = 'img/upload/devices/' . $id;
        $path = 'img/upload/devices/' . $id . '/';
        if (!file_exists($folderPath)) {
            mkdir($path, 0777, true);
        }
        foreach ($images['img'] as $value) {
            if (!empty($value['name'])) {
                $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
                $fileName = 'devices' . strtotime("now") . "." . $ext;
                $uploadPath =  $path;
                $uploadFile = $uploadPath . $fileName;
                $valiExt = array('jpg','png','jpeg','gif');
                if (in_array($ext,$valiExt)) {
                    if (move_uploaded_file($value['tmp_name'],$uploadFile)) {
                        $uploadImage = $filesTable->newEntity();
                        $uploadImage->relate_id = $id;
                        $uploadImage->relate_name = 'devices';
                        $uploadImage->path = $path;
                        $uploadImage->is_delete = 0;
                        $filesTable->save($uploadImage);
                    }else {
                        $this->payload['status'] = 'failed';
                        $this->response->body(json_encode($this->payload));
                    }
                }else {
                    $this->payload['status'] = 'failed';
                    $this->response->body(json_encode($this->payload));
                }
            }else {
                $this->payload['status'] = 'failed';
                $this->response->body(json_encode($this->payload));
            }
        }
        $this->responseApi($this->status,$this->data_name,$devices);
    }

    public function edit($id)
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->where(['id'=>$id])->first();

        $parent_id = $this->request->getData('parent_id');
        $id_cate = $this->request->getData('id_cate');
        $serial_number = $this->request->getData('serial_number');
        $product_number = $this->request->getData('product_number');
        $name = $this->request->getData('name');
        $brand_id = $this->request->getData('brand_id');
        $specifications = $this->request->getData('specifications');
        $status = $this->request->getData('status');
        $warranty_period = $this->request->getData('warranty_period');  
        $created_time = $this->request->getData('created_time'); 
        $update_time = $this->request->getData('update_time'); 
        $is_deleted = $this->request->getData('is_deleted'); 
        $devicesTable = TableRegistry::get('Devices');
       
    
        if ($this->request->is(['post', 'put'])) {
            $devices = $this->Devices->patchEntity($devices, $this->request->getData());
            if ($this->Devices->save($devices)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        $this->payload['payload']['devices'] = $devices;
        $this->response->body(json_encode($this->payload));
    }

    public function delete()
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->find('all');
        $message = "Deleted";
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
        $this->responseApi($this->status,$this->data_name,$message);
    }
}
