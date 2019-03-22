<?php
namespace App\Controller;

use App\Controller\AppController;

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
            ]);

        $borrow_devices_quantity = $this->BorrowDevices->find()->select(['count' => 'count(1)'])
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
            ]);
        if (isset($inputData['borrower_id']) && $inputData['borrower_id'] != null) {
            $condition = array_merge($condition, ['BorrowDevices.borrower_id' => trim($inputData['borrower_id'])]);
        }
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
        if (isset($inputData['device_name']) && !empty($inputData['device_name'])) {
            $condition = array_merge($condition, ['Devices.name LIKE' => '%' . trim($inputData['device_name']) . '%']);
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
            ])
            ->where([
                'BorrowDevices.id' => $id,
                'BorrowDevices.is_deleted' => 0,
            ])->first();

        if (empty($borrowDevice)) {
            $this->status = 'fail';
            $this->data_name = 'message';
            $borrowDevice = 'Data not found';
        }

        $this->responseApi($this->status, $this->data_name, $borrowDevice);
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
        array_push($list_id, (int) trim($this->getRequest()->getData('device_id')));
        $borrowDevice = $this->BorrowDevices->newEntity();
        $inputData['borrower_id'] = trim($this->getRequest()->getData('borrower_id'));
        $inputData['borrow_reason'] = trim($this->getRequest()->getData('borrow_reason'));
        $inputData['borrow_date'] = trim($this->getRequest()->getData('borrow_date'));
        $inputData['created_user'] = 'borrow device';

        $save_data_status = $this->saveBorrowDevices($inputData, $this->getIdDevices($list_id));
        if ($save_data_status['status']) {
            $category = ['id' => $save_data_status['id']];
        } else {
            $this->status = 'fail';
            $this->data_name = 'error';
            $category = $save_data_status['error'];
        }

        $this->responseApi($this->status, $this->data_name, $category);
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
        $borrowDevice = $this->BorrowDevices->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $borrowDevice = $this->BorrowDevices->patchEntity($borrowDevice, $this->request->getData());
            if ($this->BorrowDevices->save($borrowDevice)) {
                $this->Flash->success(__('The borrow device has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The borrow device could not be saved. Please, try again.'));
        }
        // $borrowers = $this->BorrowDevices->Borrowers->find('list', ['limit' => 200]);
        // $approveds = $this->BorrowDevices->Approveds->find('list', ['limit' => 200]);
        // $handovers = $this->BorrowDevices->Handovers->find('list', ['limit' => 200]);
        // $this->set(compact('borrowDevice', 'approveds', 'handovers'));
        $this->payload['payload']['borrowDevice'] = $borrowDevice;
        $this->response->body(json_encode($this->payload));
        return $this->response;
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
        $this->request->allowMethod(['post', 'delete']);
        $borrowDevice = $this->BorrowDevices->get($id);
        if ($this->BorrowDevices->delete($borrowDevice)) {
            $this->Flash->success(__('The borrow device has been deleted.'));
        } else {
            $this->Flash->error(__('The borrow device could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * get id user method
     *
     * @param string user name
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
     * @param int id device
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
            $arr = array_map(array($this, 'convertDeviceId'), $data);
            return array_merge($id, $this->getIdDevices($arr));
        }
    }

    /**
     * Convert device id method
     *
     * @param int id device
     * @return string id device
     */
    private function convertDeviceId($data) {
        return $data['id'];
    }
    /**
     * Save table BorrowDevices
     *
     * @param array $input_data.
     * @return true|false
     */
    public function saveBorrowDevices($input_data = [], $list_id = [], $result = true)
    {
        $id_borrow_device = null;
        $error = null;
        $this->BorrowDevices->getConnection()->transactional(function () use ($input_data, $list_id, &$result, &$id_borrow_device, &$error) {
            $borrow_device = $this->BorrowDevices->newEntity();
            $borrow_device = $this->BorrowDevices->patchEntity($borrow_device, $input_data);

            if ($data = $this->BorrowDevices->save($borrow_device)) {
                $id_borrow_device = $data->id;
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
            
            foreach($list_id as $id_device) {
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
        });

        return $result;
    }
}
