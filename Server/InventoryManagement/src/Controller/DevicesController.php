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
        $condition = ['is_deleted' => 0];
        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->find();
        $device_quantity = $devicesTable->find()->select(['count' => 'count(1)']);

        if (isset($input_data['id_cate']) && $input_data['id_cate'] != null) {
            array_push($condition, ['id_cate' => trim($input_data['id_cate'])]);
        }
        if (isset($input_data['serial_number']) && !empty($input_data['serial_number'])) {
            array_push($condition, ['serial_number LIKE' => '%' . trim($input_data['serial_number']) . '%']);
        }
        if (isset($input_data['product_number']) && !empty($input_data['product_number'])) {
            array_push($condition, ['product_number LIKE' => '%' . trim($input_data['product_number']) . '%']);
        }
        if (isset($input_data['name']) && !empty($input_data['name'])) {
            array_push($condition, ['name LIKE' => '%' . trim($input_data['name']) . '%']);
        }
        if (isset($input_data['brand_id']) && $input_data['brand_id'] != null) {
            array_push($condition, ['brand_id' => trim($input_data['brand_id'])]);
        }
        if (isset($input_data['specifications']) && !empty($input_data['specifications'])) {
            array_push($condition, ['specifications LIKE' => '%' . trim($input_data['specifications']) . '%']);
        }
        if (isset($input_data['status']) && $input_data['status'] != null) {
            array_push($condition, ['status' => trim($input_data['status'])]);
        }

        $devices->where($condition)
            ->order(['id' => 'DESC'])
            ->limit($this->perpage)
            ->page($this->page);
        $record_all = $device_quantity->where($condition)->first();
        $this->responseApi($this->status, $this->data_name, $devices, $record_all['count']);
    }

    public function view()
    {
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

        $devicesTable = TableRegistry::get('Devices');
        $devices = $devicesTable->newEntity();

        $inputData['parent_id'] = trim($this->getRequest()->getData('parent_id'));
        $inputData['id_parent'] = trim($this->getRequest()->getData('id_parent'));
        $inputData['id_cate'] = trim($this->getRequest()->getData('id_cate'));
        $inputData['serial_number'] = trim($this->getRequest()->getData('serial_number'));
        $inputData['product_number'] = trim($this->getRequest()->getData('product_number'));
        $inputData['name'] = trim($this->getRequest()->getData('name'));
        $inputData['brand_id'] = trim($this->getRequest()->getData('brand_id'));
        $inputData['specifications'] = trim($this->getRequest()->getData('specifications'));
        $inputData['warranty_period'] = trim($this->getRequest()->getData('warranty_period'));
        $inputData['created_user'] = 'device';

        //validate
        $devices = $this->Devices->patchEntity($devices, $inputData);
        if ($data = $this->Devices->save($devices)) {
            $device = ['id' => $data->id];
        } else {
            $this->status = 'failed';
            $this->data_name = 'error';
            $device = $devices->getErrors();
        }
        $this->responseApi($this->status, $this->data_name, $device);
    }

    public function addImage()
    {
        //add image devices
        $devicesTable = TableRegistry::get('Devices');
        $id = $this->getRequest()->getData('id');
        if ($id != null) {
            $filesTable = TableRegistry::get('Files');
            $images = $this->request->getData();
            $path = 'img/upload/devices/' . $id;
            if (!file_exists($path)) {
                mkdir($path . '/', 0777, true);
            }
            foreach ($images['img'] as $value) {
                if (!empty($value['name'])) {
                    $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
                    $fileName = 'devices' . strtotime("now") . "." . $ext;
                    $uploadPath = $path . '/';
                    $uploadFile = $uploadPath . $fileName;
                    $valiExt = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($ext, $valiExt)) {
                        if (move_uploaded_file($value['tmp_name'], $uploadFile)) {
                            $uploadImage = $filesTable->newEntity();
                            $uploadImage->relate_id = $id;
                            $uploadImage->relate_name = 'devices';
                            $uploadImage->path = $path . '/' . $fileName;
                            $uploadImage->type = 'detail';
                            $uploadImage->is_delete = 0;
                            if ($filesTable->save($uploadImage)) {
                                $message = "Image saved!";
                            }else {
                                $message = "Failed to save!";
                            }
                        } else {
                            $message = "Unable to upload image, please try again!";
                            $this->status = 'failed';
                        }
                    } else {
                        $message = "Please choose an image has type like jpg, png,... to upload!";
                        $this->status = 'failed';
                    }
                } else {
                    $message = "Please choose an image to upload!";
                    $this->status = 'failed';
                }
            }
        }else {
            $message = "Please input id to save an image!";
            $this->status = 'failed';
        }
        $this->responseApi($this->status, $this->data_name, $message);
    }

    public function edit()
    {
        //edit
        $devicesTable = TableRegistry::get('Devices');
        $id = $this->request->getData('id');
        $devices = $devicesTable->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0
            ])->first();
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
            $inputData['warranty_period'] = trim($this->getRequest()->getData('warranty_period'));
            $inputData['update_user'] = 'device';

            $devices = $this->Devices->patchEntity($devices, $inputData);
            if ($this->Devices->save($devices)) {
                $message = 'Saved!';
            } else {
                $message = $devices->errors();
                $this->status = 'failed';
            }
        } else {
            $this->status = 'fail';
            $this->data_name = 'message';
            $category = 'Data not found!';
        }

        $this->responseApi($this->status, $this->data_name, $devices, $message);
    }

    public function editImage()
    {
        $devicesTable = TableRegistry::get('Devices');
        $id = $this->request->getData('id');

        $filesTable = TableRegistry::get('Files');
        $images = $filesTable->find()->where(['relate_id' => $id , 'is_deleted' => 0 , 'relate_name' => 'devices'])->first();
        $editImg = $this->request->getData();
        $path = 'img/upload/devices/' . $id;
        $imgName = str_replace($path . '/','',$images->path);
        
        if (file_exists($path)) {
            unlink($path . '/' . $imgName);
        }
        foreach ($editImg['img'] as $value) {
            if (!empty($value['name'])) {
                $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
                $fileName = 'devices' . strtotime("now") . "." . $ext;
                $uploadPath = $path . '/';
                $uploadFile = $uploadPath . $fileName;
                $valiExt = array('jpg', 'png', 'jpeg', 'gif');
                if (in_array($ext, $valiExt)) {
                    if (move_uploaded_file($value['tmp_name'], $uploadFile)) {
                        $uploadImage = $images;
                        $uploadImage->relate_id = $id;
                        $uploadImage->relate_name = 'devices';
                        $uploadImage->path = $path . '/' . $fileName;
                        $uploadImage->type = 'detail';
                        $uploadImage->is_delete = 0;
                        if ($filesTable->save($uploadImage)) {
                            $message = "Image saved!";
                        }else {
                            $message = "Failed to save!";
                        }
                    } else {
                        $message = "Unable to upload image, please try again!";
                        $this->status = 'failed';
                    }
                } else {
                    $message = "Please choose an image has type like jpg, png,... to upload!";
                    $this->status = 'failed';
                }
            } else {
                $message = "Please choose an image to upload!";
                $this->status = 'failed';
            }
        }
        $this->responseApi($this->status, $this->data_name, $message);
    }

    public function delete()
    {
        //delete logic device
        $devicesTable = TableRegistry::get('Devices');
        $devices = $this->request->getData();
        $id = $devices['id'];
        //img
        $filesTable = TableRegistry::get('Files');
        $images = $filesTable->find()->where(['relate_id' => $id ,'is_deleted' => 0 , 'relate_name' => 'devices'])->all()->toArray();
        $path = 'img/upload/devices/' . $id;
        //check
        if ($id != null) {
            $devices = $devicesTable->get($id);
            $devices->is_deleted = 1;
            $devices = $this->Devices->patchEntity($devices, $this->request->getData());
            if ($devicesTable->save($devices)) {
                foreach ($images as $value) {
                    unlink($value->path);
                }
                $filesTable->deleteAll(['relate_id' => $id , 'relate_name' => 'devices']);
                rmdir($path);
                $message = "Deleted!";
            } else {
                $message = "Failed to delete!";
                $this->status = 'failed';
            }
        }else {
            $message = "Please input id to show record!";
            $this->status = 'failed';
        }
        $this->responseApi($this->status, $this->data_name, $message);
    }
}
