<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * BorrowDevices Controller
 *
 * @property \App\Model\Table\BorrowDevicesTable $BorrowDevices
 *
 * @method \App\Model\Entity\BorrowDevice[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BorrowDevicesController extends AppController
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
     *  Status Flg  0:add|edit, 1:Delete, 2: aprroved
     */
    public $flg_modified;

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
        $this->data_name = 'borrow_devices';

        $this->loadModel('Users');
        $this->loadModel('BorrowDevicesDetail');
        $this->loadModel('Devices');
        $this->flg_modified = 0;
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
        $condition = ['BorrowDevices.is_deleted' => 0];
        $borrow_devices = $this->BorrowDevices->find()
            ->select([
                'path' => 'Files.path',
                'device_name' => 'Devices.name',
                'serial_number' => 'Devices.serial_number',
                'product_number' => 'Devices.product_number',
                'brand_name' => 'Brands.brand_name',
                'status' => 'BorrowDevices.status',
                'category_name' => 'Categories.category_name',
            ])
            ->join([
                'BorrowDevicesDetail' => [
                    'table' => 'borrow_devices_detail',
                    'type' => 'INNER',
                    'conditions' => [
                        'BorrowDevicesDetail.borrow_device_id = BorrowDevices.id',
                        'BorrowDevicesDetail.is_deleted = 0',
                    ],
                ],
                'Devices' => [
                    'table' => 'devices',
                    'type' => 'INNER',
                    'conditions' => [
                        'Devices.id = BorrowDevicesDetail.device_id',
                        'Devices.is_deleted = 0',
                    ],
                ],
                'Users' => [
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => [
                        'Users.id = BorrowDevices.borrower_id',
                        'Users.is_deleted = 0',
                    ],
                ],
                'Files' => [
                    'table' => 'files',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Files.relate_id = Devices.id',
                        'Files.is_deleted = 0',
                    ],
                ],
                'Brands' => [
                    'table' => 'brands',
                    'type' => 'INNER',
                    'conditions' => [
                        'Brands.id = Devices.brand_id',
                        'Brands.is_deleted = 0',
                    ],
                ],
                'Categories' => [
                    'table' => 'categories',
                    'type' => 'INNER',
                    'conditions' => [
                        'Categories.id = Devices.id_cate',
                        'Categories.is_deleted = 0',
                    ],
                ],
            ]);

        $borrow_devices_quantity = $this->BorrowDevices->find()
            ->select(['count' => 'count(1)'])
            ->join([
                'BorrowDevicesDetail' => [
                    'table' => 'borrow_devices_detail',
                    'type' => 'INNER',
                    'conditions' => [
                        'BorrowDevicesDetail.borrow_device_id = BorrowDevices.id',
                        'BorrowDevicesDetail.is_deleted = 0',
                    ],
                ],
                'Devices' => [
                    'table' => 'devices',
                    'type' => 'INNER',
                    'conditions' => [
                        'Devices.id = BorrowDevicesDetail.device_id',
                        'Devices.is_deleted = 0',
                    ],
                ],
                'Users' => [
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => [
                        'Users.id = BorrowDevices.borrower_id',
                        'Users.is_deleted = 0',
                    ],
                ],
                'Files' => [
                    'table' => 'files',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Files.relate_id = Devices.id',
                        'Files.is_deleted = 0',
                    ],
                ],
                'Brands' => [
                    'table' => 'brands',
                    'type' => 'INNER',
                    'conditions' => [
                        'Brands.id = Devices.brand_id',
                        'Brands.is_deleted = 0',
                    ],
                ],
                'Categories' => [
                    'table' => 'categories',
                    'type' => 'INNER',
                    'conditions' => [
                        'Categories.id = Devices.id_cate',
                        'Categories.is_deleted = 0',
                    ],
                ],
            ]);

        if (isset($inputData['borrower_name']) && !empty($inputData['borrower_name'])) {
            $condition = array_merge($condition, ['OR' => [
                'Users.user_name LIKE' => '%' . trim($inputData['borrower_name']) . '%',
                'Users.full_name LIKE' => '%' . trim($inputData['borrower_name']) . '%',
            ]]);
        }
        if (isset($inputData['approved_name']) && !empty($inputData['approved_name'])) {
            $id_user = $this->__getIdUser($inputData['approved_name']);
            if ($id_user != null) {
                $condition = array_merge($condition, ['BorrowDevices.approved_id' => $id_user]);
            }
        }
        if (isset($inputData['handover_name']) && $inputData['handover_name'] != null) {
            $id_user = $this->__getIdUser($inputData['handover_name']);
            if ($id_user != null) {
                $condition = array_merge($condition, ['BorrowDevices.handover_id' => $id_user]);
            }
        }
        if (isset($inputData['borrow_date']) && !empty($inputData['borrow_date'])) {
            $condition = array_merge($condition, ['DATE_FORMAT(BorrowDevices.borrow_date,\'%Y-%m-%d\')' => trim($inputData['borrow_date'])]);
        }
        if (isset($inputData['return_date']) && !empty($inputData['return_date'])) {
            $condition = array_merge($condition, ['DATE_FORMAT(BorrowDevices.return_date,\'%Y-%m-%d\')' => trim($inputData['return_date'])]);
        }
        if (isset($inputData['approved_date']) && !empty($inputData['approved_date'])) {
            $condition = array_merge($condition, ['DATE_FORMAT(BorrowDevices.approved_date,\'%Y-%m-%d\')' => trim($inputData['approved_date'])]);
        }
        if (isset($inputData['delivery_date']) && !empty($inputData['delivery_date'])) {
            $condition = array_merge($condition, ['DATE_FORMAT(BorrowDevices.delivery_date,\'%Y-%m-%d\')' => trim($inputData['delivery_date'])]);
        }
        if (isset($inputData['status']) && !empty($inputData['status'])) {
            $condition = array_merge($condition, ['BorrowDevices.status' => trim($inputData['status'])]);
        }
        if (isset($inputData['category_id']) && !empty($inputData['category_id'])) {
            $condition = array_merge($condition, ['Categories.id' => trim($inputData['category_id'])]);
        }
        if (isset($inputData['device_name']) && !empty($inputData['device_name'])) {
            $condition = array_merge($condition, ['Devices.name LIKE' => '%' . trim($inputData['device_name']) . '%']);
        }
        if (isset($inputData['brand_id']) && !empty($inputData['brand_id'])) {
            $condition = array_merge($condition, ['Devices.brand_id' => trim($inputData['brand_id'])]);
        }

        $borrow_devices->where($condition)
            ->order(['BorrowDevices.id' => 'DESC'])
            ->limit($this->perpage)
            ->page($this->page);
        $record_all = $borrow_devices_quantity->where($condition)->first();

        $this->responseApi($this->status, $this->data_name, $borrow_devices, $record_all['count']);
    }

    /**
     * View method
     *
     * @param string|null $id Borrow Device id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $id = $this->getRequest()->getParam('id');

        $borrowDevice = $this->BorrowDevices->find()
            ->select([
                'borrow_name' => 'Users.user_name',
                'borrow_full_name' => 'Users.full_name',
                'borrow_reason' => 'BorrowDevices.borrow_reason',
                'return_reason' => 'BorrowDevices.return_reason',
                'status' => 'BorrowDevices.status',
                'borrow_date' => 'BorrowDevices.borrow_date',
                'approved_date' => 'BorrowDevices.approved_date',
                'delivery_date' => 'BorrowDevices.delivery_date',
                'return_date' => 'BorrowDevices.return_date',
                'approved_name' => 'USERSAPPROVED.user_name',
                'approved_full_name' => 'USERSAPPROVED.full_name',
                'handover_name' => 'USERSHANDOVER.user_name',
                'handover_full_name' => 'USERSHANDOVER.full_name',
            ])
            ->join([
                'Users' => [
                    'table' => 'users',
                    'type' => 'INNER',
                    'conditions' => [
                        'Users.id = BorrowDevices.borrower_id',
                        'Users.is_deleted = 0',
                    ],
                ],
                'USERSAPPROVED' => [
                    'table' => $this->Users->find()
                        ->select([
                            'id' => 'Users.id'
                            , 'user_name' => 'Users.user_name'
                            , 'full_name' => 'Users.full_name'
                            , 'is_deleted' => 'Users.is_deleted',
                        ]),
                    'type' => 'LEFT',
                    'conditions' => [
                        'USERSAPPROVED.is_deleted = 0',
                        'USERSAPPROVED.id = BorrowDevices.approved_id',
                    ],
                ],
                'USERSHANDOVER' => [
                    'table' => $this->Users->find()
                        ->select([
                            'id' => 'Users.id'
                            , 'user_name' => 'Users.user_name'
                            , 'full_name' => 'Users.full_name'
                            , 'is_deleted' => 'Users.is_deleted',
                        ]),
                    'type' => 'LEFT',
                    'conditions' => [
                        'USERSHANDOVER.is_deleted = 0',
                        'USERSHANDOVER.id = BorrowDevices.handover_id',
                    ],
                ],
            ])
            ->where([
                'BorrowDevices.id' => $id,
                'BorrowDevices.is_deleted' => 0,
            ])->first();

        $borrowDeviceDetail = $this->BorrowDevices->find()
            ->select([
                'id_device' => 'Devices.id',
                'name_device' => 'Devices.name',
                'serial_number' => 'Devices.serial_number',
                'product_number' => 'Devices.product_number',
                'specifications' => 'Devices.specifications',
                'warranty_period' => 'Devices.warranty_period',
                'brand_name' => 'Brands.brand_name',
                'category_name' => 'Categories.category_name',
                'path' => 'Files.path',
            ])
            ->join([
                'BorrowDevicesDetail' => [
                    'table' => 'borrow_devices_detail',
                    'type' => 'INNER',
                    'conditions' => [
                        'BorrowDevicesDetail.borrow_device_id = BorrowDevices.id',
                        'BorrowDevicesDetail.is_deleted = 0',
                    ],
                ],
                'Devices' => [
                    'table' => 'devices',
                    'type' => 'INNER',
                    'conditions' => [
                        'Devices.id = BorrowDevicesDetail.device_id',
                        'Devices.is_deleted = 0',
                    ],
                ],
                'Files' => [
                    'table' => 'files',
                    'type' => 'LEFT',
                    'conditions' => [
                        'Files.relate_id = Devices.id',
                        'Files.is_deleted = 0',
                    ],
                ],
                'Brands' => [
                    'table' => 'brands',
                    'type' => 'INNER',
                    'conditions' => [
                        'Brands.id = Devices.brand_id',
                        'Brands.is_deleted = 0',
                    ],
                ],
                'Categories' => [
                    'table' => 'categories',
                    'type' => 'INNER',
                    'conditions' => [
                        'Categories.id = Devices.id_cate',
                        'Categories.is_deleted = 0',
                    ],
                ],
            ])
            ->where([
                'BorrowDevices.id' => $id,
                'BorrowDevices.is_deleted' => 0,
            ])->all();

        $data = [
            'borrow' => $borrowDevice,
            'borrow_detail' => $borrowDeviceDetail,
        ];
        if (empty($borrowDevice)) {
            $this->status = 'fail';
            $this->data_name = 'message';
            $data = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $data);
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

        $list_id = [];
        array_push($list_id, (int)trim($this->getRequest()->getData('device_id')));
        $borrowDevice = $this->BorrowDevices->newEntity();
        $inputData['borrower_id'] = trim($this->getRequest()->getData('borrower_id'));
        $inputData['borrow_reason'] = trim($this->getRequest()->getData('borrow_reason'));
        $inputData['borrow_date'] = trim($this->getRequest()->getData('borrow_date'));
        $inputData['status'] = 0;
        $inputData['created_user'] = trim($this->getRequest()->getData('created_user'));
        $inputData['update_user'] = null;

        $save_data_status = $this->saveBorrowDevices($inputData, $this->getIdDevices($list_id));

        if ($save_data_status['status']) {
            $borrowDevice = ['id' => $save_data_status['id']];
        } else {
            $this->status = 'fail';
            $this->data_name = 'error';
            $borrowDevice = $save_data_status['error'];
        }

        $this->responseApi($this->status, $this->data_name, $borrowDevice);
    }

    /**
     * Edit method
     *
     * @param string|null $id Borrow Device id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // Only accept PATCH POST and PUT requests
        $this->request->allowMethod(['patch', 'post', 'put']);

        $id = $this->getRequest()->getData('id');

        $borrowDevice = $this->BorrowDevices->find()
            ->where([
                'status' => 0,
                'is_deleted' => 0,
                'id' => $id,
                'borrower_id' => trim($this->getRequest()->getData('created_user')),
            ])->first();
        if ($borrowDevice) {
            $list_id = [];
            array_push($list_id, (int)trim($this->getRequest()->getData('device_id')));
            $inputData['borrower_id'] = trim($this->getRequest()->getData('borrower_id'));
            $inputData['borrow_reason'] = trim($this->getRequest()->getData('borrow_reason'));
            $inputData['borrow_date'] = trim($this->getRequest()->getData('borrow_date'));
            $inputData['created_user'] = trim($this->getRequest()->getData('created_user'));
            $inputData['update_user'] = trim($this->getRequest()->getData('update_user'));
            $inputData['update_time'] = Time::now();

            $save_data_status = $this->saveBorrowDevices($inputData, $this->getIdDevices($list_id), $id);

            if ($save_data_status['status']) {
                $borrowDevice = ['id' => $save_data_status['id']];
            } else {
                $this->status = 'fail';
                $this->data_name = 'error';
                $borrowDevice = $save_data_status['error'];
            }
        } else {
            $this->status = 'fail';
            $this->data_name = 'message';
            $borrowDevice = 'Data not found, unable to edit when approved or only borrowers can fix it ';
        }

        $this->responseApi($this->status, $this->data_name, $borrowDevice);
    }

    /**
     * Delete method
     *
     * @param string|null $id Borrow Device id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        // Only accept POST and DELETE requests
        $this->request->allowMethod(['delete', 'post']);

        $id = $this->getRequest()->getData('id');

        $borrowDevice = $this->BorrowDevices->find()
            ->where([
                'is_deleted' => 0,
                'id' => $id,
                'borrower_id' => trim($this->getRequest()->getData('created_user')),
            ])->first();

        if ($borrowDevice) {
            //Set delete flg is 1
            $this->flg_modified = 1;
            $list_id = [];
            $inputData['created_user'] = trim($this->getRequest()->getData('created_user'));
            $inputData['update_user'] = trim($this->getRequest()->getData('update_user'));
            $inputData['update_time'] = Time::now();

            $save_data_status = $this->saveBorrowDevices($inputData, $list_id, $id);

            if ($save_data_status['status']) {
                $this->data_name = 'message';
                $borrowDevice = 'Delete data successfully';
            } else {
                $this->status = 'fail';
                $this->data_name = 'error';
                $borrowDevice = 'Delete data failed';
            }
        } else {
            $this->status = 'fail';
            $this->data_name = 'message';
            $borrowDevice = 'Data not found or only borrowers can delete it';
        }

        $this->responseApi($this->status, $this->data_name, $borrowDevice);
    }

    /**
     * Approved method
     */
    public function approved()
    {
        // Only accept PATCH POST and PUT requests
        $this->request->allowMethod(['patch', 'post', 'put']);

        $id = $this->getRequest()->getData('id');

        $borrowDevice = $this->BorrowDevices->find()
            ->where([
                'is_deleted' => 0,
                'id' => $id,
            ])->first();
        if ($borrowDevice) {
            //Set approved flg is 2
            $this->flg_modified = 2;
            $list_id = [];
            $inputData['status'] = trim($this->getRequest()->getData('status'));
            $inputData['device_id'] = (int) trim($this->getRequest()->getData('device_id'));
            $inputData['borrow_date'] = trim($this->getRequest()->getData('borrow_date'));
            $inputData['approved_id'] = trim($this->getRequest()->getData('approved_id'));
            $inputData['approved_date'] = trim($this->getRequest()->getData('approved_date'));
            $inputData['created_user'] = trim($this->getRequest()->getData('created_user'));
            $inputData['update_user'] = trim($this->getRequest()->getData('update_user'));
            $inputData['update_time'] = Time::now();

            //Get the divice id list
            if (empty($inputData['device_id'])) {
                $list_id = $this->__getListDevicesId($id);
            } else {
                array_push($list_id, $inputData['device_id']);
                $list_id = $this->getIdDevices($list_id);
            }
            $save_data_status = $this->saveBorrowDevices($inputData, $list_id, $id);

            if ($save_data_status['status']) {
                $this->data_name = 'message';
                $borrowDevice = 'Approve data successfully';
            } else {
                $this->status = 'fail';
                $this->data_name = 'error';
                $borrowDevice = 'Approve data failed';
            }
        } else {
            $this->status = 'fail';
            $this->data_name = 'message';
            $borrowDevice = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $borrowDevice);
    }

    /**
     *  get the device id list
     *
     * @param int $borrow_id borrower code
     */
    private function __getListDevicesId($borrow_id = null)
    {
        $data = $this->BorrowDevicesDetail->find()
            ->select([
                'id' => 'device_id'
            ])
            ->where([
                'borrow_device_id' => $borrow_id,
                'is_deleted' => 0,
            ])
            ->all()
            ->toArray();
        return array_map(array($this, '__convertDeviceId'), $data);
    }

    /**
     * get id user method
     *
     * @param string $user_name
     * @return string|null $id user
     */
    private function __getIdUser($user_name = null)
    {
        $data = $this->Users->find()
            ->select(['id'])
            ->where([
                'OR' => [
                    'user_name LIKE' => '%' . trim($user_name) . '%',
                    'full_name LIKE' => '%' . trim($user_name) . '%',
                ],
                'is_deleted' => 0,
            ])
            ->first();
        return $data['id'];
    }

    /**
     * get id user method
     *
     * @param int $id  device id
     * @return array|null id device list
     */
    public function getIdDevices($id = null)
    {
        $data = $this->Devices->find()
            ->select(['id'])
            ->where([
                'parent_id in' => $id,
                'is_deleted' => 0,
            ])
            ->all()->toArray();

        if (empty($data)) {
            return $id;
        } else {
            $arr = array_map(array($this, '__convertDeviceId'), $data);
            return array_merge($id, $this->getIdDevices($arr));
        }
    }

    /**
     * Convert device id method
     *
     * @param array $data device list
     * @return string device id
     */
    private function __convertDeviceId($data)
    {
        return $data['id'];
    }
    /**
     * Save table BorrowDevices
     *
     * @param array $input_data.
     * @return true|false
     */
    public function saveBorrowDevices($input_data = [], $list_id = [], $id_borrow_device = null, $result = true, $error = null)
    {
        $this->BorrowDevices->getConnection()->transactional(function () use ($input_data, $list_id, &$result, &$id_borrow_device, &$error) {
            // check if is create
            if (empty($id_borrow_device)) {
                $borrow_device = $this->BorrowDevices->newEntity();
            } elseif ($this->flg_modified == 0) {
                $borrow_device = $this->BorrowDevices->find()
                    ->where([
                        'is_deleted' => 0,
                        'id' => $id_borrow_device,
                        'status' => 0,
                    ])->first();
            } elseif ($this->flg_modified == 2) {
                $borrow_device = $this->BorrowDevices->find()
                    ->where([
                        'is_deleted' => 0,
                        'id' => $id_borrow_device,
                    ])->first();
            } else {
                $input_data['is_deleted'] = 1;
                $borrow_device = $this->BorrowDevices->find()
                    ->where([
                        'is_deleted' => 0,
                        'id' => $id_borrow_device,
                    ])->first();
            }

            $borrow_device = $this->BorrowDevices->patchEntity($borrow_device, $input_data);

            if ($data = $this->BorrowDevices->save($borrow_device)) {
                if (empty($id_borrow_device)) {
                    $id_borrow_device = $data->id;
                }
                return $this->saveBorrowDevicesDetail($input_data, $list_id, $id_borrow_device, $result, $error);
            } else {
                $result = false;
                $error = $borrow_device->getErrors();
                return $result;
            }
        });

        $ret = [
            "status" => $result,
            "id" => $id_borrow_device,
            "error" => $error,
        ];
        return $ret;
    }

    /**
     * Save table BorrowDevices
     *
     * @param array $input.
     * @param int $id borrow devices.
     * @return true|false
     */
    public function saveBorrowDevicesDetail($input_data, $list_id, $id, &$result, &$error)
    {
        $this->BorrowDevicesDetail->getConnection()->transactional(function () use ($input_data, $list_id, $id, &$result, &$error) {
            $input_data['borrow_device_id'] = $id;

            $delete_borrow_detail = $this->BorrowDevicesDetail->query();
            if ($this->flg_modified != 2 || ($this->flg_modified == 2 && !empty($input_data['device_id']))) {
                // Delele record
                $delete_borrow_detail->update()
                    ->set([
                        'created_user' => $input_data['created_user'],
                        'update_user' => $input_data['update_user'],
                        'update_time' => Time::now(),
                        'is_deleted' => 1,
                    ])
                    ->where([
                        'borrow_device_id' => $id,
                        'is_deleted' => 0,
                    ])->execute();
            }

            if ($this->flg_modified == 0 || ($this->flg_modified == 2 && !empty($input_data['device_id']))) {
                
                // Add new record
                foreach ($list_id as $id_device) {
                    $input_data['device_id'] = $id_device;
                    $borrow_device_detail = $this->BorrowDevicesDetail->newEntity();
                    $borrow_device_detail = $this->BorrowDevicesDetail->patchEntity($borrow_device_detail, $input_data);

                    if ($this->BorrowDevicesDetail->save($borrow_device_detail)) {
                        $result = true;
                    } else {
                        $result = false;
                        $error = $borrow_device_detail->getErrors();
                        return $result;
                    }
                }
            }
            
            if ($this->flg_modified == 2) {
                //Update approved date for borrower
                $update_borrow_detail = $this->BorrowDevicesDetail->query();
                $update_borrow_detail->update()
                    ->set([
                        'status' => $input_data['status'],
                        'approved_date' => $input_data['approved_date'],
                        'update_user' => $input_data['update_user'],
                        'update_time' => Time::now(),
                    ])
                    ->where([
                        'borrow_device_id' => $id,
                        'is_deleted' => 0,
                    ])->execute();

                // Update device status
                $devices = $this->Devices->query();
                $devices->update()
                        ->set([
                            'update_user' => $input_data['update_user'],
                            'update_time' => Time::now(),
                            'status' => 1,
                        ])
                        ->where([
                            'id IN' => $list_id,
                            'is_deleted' => 0,
                        ])->execute();
            } 

        });

        return $result;
    }

}
