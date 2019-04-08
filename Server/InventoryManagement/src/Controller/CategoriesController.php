<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 *
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{

    /**
     *  Status result api
     */
    public $status;

    /**
     *  Data Name Table result or Message name
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
        $this->data_name = 'categories';

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
        $condition = ['is_deleted' => 0];
        $categories = $this->Categories->find();
        $categories_quantity = $this->Categories->find()->select(['count' => 'count(1)']);

        if (isset($inputData['id_parent']) && $inputData['id_parent'] != null &&
            isset($inputData['children_flg']) && $inputData['children_flg'] != 1) {
            $condition = array_merge($condition, ['id_parent' => trim($inputData['id_parent'])]);
        }
        if (isset($inputData['category_name']) && !empty($inputData['category_name'])) {
            $condition = array_merge($condition, ['category_name LIKE ' => '%' . trim($inputData['category_name']) . '%']);
        }

        if (isset($inputData['children_flg']) && $inputData['children_flg'] == 1) {
            $id_parent = [];
            if (isset($inputData['id_parent']) && $inputData['id_parent'] != null) {
                array_push($id_parent, trim($inputData['id_parent']));
            }
            foreach ($categories as $category) {
                array_push($id_parent, $category->id);
            }

            $condition = array_merge($condition, ['id_parent IN' => $id_parent]);
        }

        $categories->where($condition)
            ->order(['id' => 'DESC'])
            ->limit($this->perpage)
            ->page($this->page);
        $record_all = $categories_quantity->where($condition)->first();

        $this->responseApi($this->status, $this->data_name, $categories, $record_all['count']);

    }

    public function show()
    {
        // Only accept POST and GET requests
        $this->request->allowMethod(['post', 'get']);

        if ($this->request->is('post')) {
            $inputData = $this->getRequest()->getData();

        } elseif ($this->request->is('get')) {
            $inputData = $this->getRequest()->getQuery();
        }
        $condition = ['is_deleted' => 0, 'id_parent !=' => 0];
        $categories = $this->Categories->find();
        $categories_quantity = $this->Categories->find()->select(['count' => 'count(1)']);

        $categories->where($condition)->select(['id','category_name'])
            ->order(['id' => 'DESC'])
            ->limit($this->perpage)
            ->page($this->page);
        $record_all = $categories_quantity->where($condition)->first();

        $this->responseApi($this->status, $this->data_name, $categories, $record_all['count']);
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $id = $this->getRequest()->getParam('id');

        $category = $this->Categories
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->first();

        if (empty($category)) {
            $this->status = 'fail';
            $this->data_name = 'message';
            $category = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $category);
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

        $inputData['id_parent'] = trim($this->getRequest()->getData('id_parent'));
        $inputData['category_name'] = trim($this->getRequest()->getData('category_name'));
        $inputData['created_user'] = 'category';

        $category = $this->Categories->newEntity();
        $category = $this->Categories->patchEntity($category, $inputData);

        if ($data = $this->Categories->save($category)) {
            $category = ['id' => $data->id];
        } else {
            $this->status = 'fail';
            $this->data_name = 'error';
            $category = $category->getErrors();
        }

        $this->responseApi($this->status, $this->data_name, $category);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Only accept PATCH POST and PUT requests
        $this->request->allowMethod(['patch', 'post', 'put']);

        $id = $this->getRequest()->getData('id');

        $category = $this->Categories
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->first();
        //Check exist brand
        if ($category) {
            $inputData['id_parent'] = trim($this->getRequest()->getData('id_parent'));
            $inputData['category_name'] = trim($this->getRequest()->getData('category_name'));
            $inputData['update_user'] = 'category';
            $inputData['update_time'] = Time::now();
            $category = $this->Categories->patchEntity($category, $inputData);
            if ($this->Categories->save($category)) {
                $category = ['id' => $id];
            } else {
                $this->status = 'fail';
                $this->data_name = 'error';
                $category = $category->getErrors();
            }
        } else {
            $this->status = 'fail';
            $this->data_name = 'message';
            $category = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $category);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // Only accept POST and DELETE requests
        $this->request->allowMethod(['delete', 'post']);

        $id = $this->getRequest()->getData('id');

        $category = $this->Categories
            ->find()
            ->where([
                'id' => $id,
                'is_deleted' => 0,
            ])->first();
        //Check exist category
        if ($category) {
            $devices = $this->Devices->find()
                ->where([
                    'id_cate' => $id,
                    'is_deleted' => 0,
                ])
                ->all();
            // Check there are device that are using this category
            if ($devices->count() == 0) {
                $category->is_deleted = (int) 1;
                $category->update_user = 'category';
                $category->update_time = Time::now();
                if ($this->Categories->save($category)) {
                    $this->data_name = 'message';
                    $category = 'Delete data successfully';
                } else {
                    $this->status = 'fail';
                    $this->data_name = 'message';
                    $category = 'Delete data failed';
                }
            } else {
                $this->data_name = 'message';
                $category = 'Cant not delete. There are device that are using this category yet to be deleted ';
            }
        } else {
            $this->data_name = 'message';
            $category = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $category);
    }
}
