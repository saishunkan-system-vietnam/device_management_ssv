<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\Filesystem\Folder;
use Cake\View\Helper\FlashHelper;

/**
 * Devices Controller
 *
 *
 * @method \App\Model\Entity\Device[]|\Cake\getDatasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DevicesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->find('all');
        
        $this->payload['payload']['categories'] = $devices;
        $this->response->body(json_encode($this->payload));
        return $this->response;

    }

    public function view($id)
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->where(['id'=>$id])->first();
        $this->payload['payload']['categories'] = $devices;
        $this->response->body(json_encode($this->payload));
        return $this->response;
    }

    public function add()
    {
        dd($this->request->getData());
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
            if ($devicesTable->save($devices)) {
                $devicesId = $devicesTable->id;
            }

            $fileImg = TableRegistry::get('Files');
            $data = $fileImg->getData();
            $images = $data['name'];
            $path = '/img/devices/'.$id;
            if (file_exists($path)) {
                App::uses('Folder', 'Utility');
                $dir = new Folder($path,true);
            }
            foreach ($images as $value) {
                if (!empty($value['name'])) {
                    $fileName = $value['name'];
                    $uploadPath = 'devices' . $path;
                    $uploadFile = $uploadPath + $fileName;
                    if (move_uploaded_file($value['tmp_name'],$uploadFile)) {
                        $uploadImage = $this->Files->newEntity();
                        $uploadImage->relate_id = $devicesId;
                        $uploadImage->relate_name = 'devices';
                        $uploadImage->path = $path;
                        $uploadImage->is_delete = 0;
                        $this->Files->save($uploadImage);
                    }else {
                        $this->Flash->error(__('Unable to upload file, please try again.'));
                    }
                }else {
                    $this->Flash->error(__('Please choose a file to upload.'));
                }
            }
        }
        $this->payload['payload']['devices'] = $devices;
        $this->response->body(json_encode($this->payload));
        return $this->response;
    }

    public function edit($id)
    {
        if($this->request->is('post')){
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
            $devices = $devicesTable->get($id);
        }
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
        return $this->response;
    }

    public function delete($id)
    {
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->where(['id'=>$id])->first();
        $devicesTable->delete($devices);
        $message = "Deleted";
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}
