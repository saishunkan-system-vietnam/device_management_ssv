<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Files Controller
 *
 *
 * @method \App\Model\Entity\File[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FilesController extends AppController
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
    public function add()
    {
        //add image devices
        $this->request->allowMethod(['post']);

        $id = $this->getRequest()->getData('id');
        $relate_name = $this->getRequest()->getData('relate_name');
        $type = $this->getRequest()->getData('type');
        if ($id != null) {
            $images = $this->request->getData();
            $path = "img/upload/$relate_name/$id";
            if (!file_exists($path)) {
                mkdir($path . '/', 0777, true);
            }
            foreach ($images['img'] as $value) {
                if (!empty($value['name'])) {
                    $ext = pathinfo($value['name'], PATHINFO_EXTENSION);
                    $fileName = $relate_name . strtotime("now") . "." . $ext;
                    $uploadPath = $path . '/';
                    $uploadFile = $uploadPath . $fileName;
                    $valiExt = array('jpg', 'png', 'jpeg', 'gif');
                    if (in_array($ext, $valiExt)) {
                        if (move_uploaded_file($value['tmp_name'], $uploadFile)) {
                            $uploadImage = $this->Files->newEntity();
                            $uploadImage->relate_id = $id;
                            $uploadImage->relate_name = $relate_name;
                            $uploadImage->path = $uploadFile;
                            $uploadImage->type = $type;
                            $uploadImage->is_delete = 0;
                            if ($this->Files->save($uploadImage)) {
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

    public function delete() {
        //add image devices
        $this->request->allowMethod(['post']);

        $id = $this->getRequest()->getData('id');
        $image = $this->Files->get($id);
        if ($image) {
            $str = $image->path;
            if ($this->Files->delete($image)) {
                if (is_file($str)) {
                    //Attempt to delete it.
                    unlink($str);
                }
                $message = "Deleted!";
            }
            else {
                $message = "Failed to delete!";
                $this->status = 'failed';
            }
        } else {
            $message = "Please input id to delete images!";
            $this->status = 'failed';
        }
        $this->responseApi($this->status, $this->data_name, $message);
    }
}
