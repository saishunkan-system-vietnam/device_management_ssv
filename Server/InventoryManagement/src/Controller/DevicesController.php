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
        //search
        $devicesTable = TableRegistry::get('Devices');
        $search = $this->request->getData('search');
        $devices = $devicesTable->find();
        $this->responseApi($this->status,$this->data_name,$devices);
    }

    public function view()
    {
        //view by id
        $devicesTable = TableRegistry::get('Devices');
        $id = $this->request->getData('id');
        $devices = $devicesTable->find()->where(['id' => $id])->all();
        $this->responseApi($this->status,$this->data_name,$devices);
    }

    public function add()
    {
        //add device info
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->newEntity();
        if($this->request->is('post')){
            //validate
            $devices = $this->Devices->patchEntity($devices, $this->request->getData());
            if ($this->Devices->save($devices)) {
                $message = "Saved";
                $this->responseApi($this->status,$this->data_name,$devices,$message);
            } else {
                $message =  $devices->errors();
                $this->status = 'failed';
                $this->responseApi($this->status,$this->data_name,$message);
            }
        }
    }

    public function addImage()
    {  
        //add image devices
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
                        $message = "Unable to upload image, please try again!";
                        $this->status = 'failed';
                    }
                }else {
                    $message = "Please choose an image has type like jpg, png,... to upload!";
                    $this->status = 'failed';
                }
            }else {
                $message = "Please choose an image to upload!";
                $this->status = 'failed';
            }
        }
        $this->responseApi($this->status,$this->data_name,$devices,$message);
    }

    public function edit()
    {
        //edit
        $devicesTable = TableRegistry::get('Devices');
        $devices = $this->request->getData();
        $id = $devices['id'];  
        $devices = $devicesTable->get($id);
        if ($this->request->is('post')) {
            $devices = $this->Devices->patchEntity($devices, $this->request->getData());
            if ($this->Devices->save($devices)) {
                $message = 'Saved';               
            } else {
                $message = $devices->errors();
                $this->status = 'failed';
            }
        }
        $this->responseApi($this->status,$this->data_name,$devices,$message);
    }

    public function delete()
    {
        //delete
        $devicesTable = TableRegistry::get('Devices');
        $devices = $this->request->getData();
        $id = $devices['id'];
        $devices = $devicesTable->get($id);
        $devices->is_deleted = 1;
        $devices = $this->Devices->patchEntity($devices, $this->request->getData());
        if ($devicesTable->save($devices)) {
            $message = "Deleted";
        }else {
            $message = "Failed to delete";
            $this->status = 'failed';
        }
        $this->responseApi($this->status,$this->data_name,$message);
    }
}
