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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->request->is('post')) {
            $inputData = $this->request->getData();
        }
        elseif ($this->request->is('get')) {
            $inputData = $this->request->getQuery(); 
        }
        $query = $this->BorrowDevices->find()->select(
            [
                'borrower_name' => 'u.user_name',
                'name_device' => 'd.name',
                'borrower_id',
                'borrow_date',
                'return_date',
                'approved_date',
                'delivery_date',
                'status',
                'handover' => 'hv.user_name',
                'approved_name'=>'hv.user_name',
                'full_name'=>'u.fullname'
            ]
        )
        ->join([
            'u'=>[
                'table' => 'users',
                'alias' => 'u',
                'type' => 'LEFT',
                'conditions' => 'BorrowDevices.borrower_id = u.id',
            ],
            'd'=>[
                'table' => 'devices',
                'alias' => 'd',
                'type' => 'LEFT',
                'conditions' => 'd.id = BorrowDevices.device_id'
            ],
            'hv'=>[
                'table' => 'users',
                'alias' => 'hv',
                'type' => 'LEFT',
                'conditions' => 'BorrowDevices.handover_id = u.id'
            ],
            'ap'=>[
                'table' => 'users',
                'alias' => 'ap',
                'type' => 'LEFT',
                'conditions' => 'BorrowDevices.approved_id = u.id'
            ]
            
        ]);
        if (!empty($inputData['user_name'])) {
            $query->where(
            [
                'u.user_name LIKE' => "%".$inputData['user_name']."%"
            ]
            );
        }
        if (!empty($inputData['name'])){
            $query->where(
            [
                'd.name LIKE' => "%".$inputData['name']."%"
            ]
            );
        }
        if (!empty($inputData['borrow_date'])){
            $query->where(
            [
                'BorrowDevices.borrow_date LIKE' => "%".$inputData['borrow_date']."%"
            ]
            );
        }
        if (!empty($inputData['return_date'])){
            $query->where(
            [
                'BorrowDevices.return_date LIKE' => "%".$inputData['return_date']."%"
            ]
            );
        }
        if (!empty($inputData['approved_date'])){
            $query->where(
            [
                'BorrowDevices.approved_date LIKE' => "%".$inputData['approved_date']."%"
            ]
            );
        }
        if (!empty($inputData['delivery_date'])){
            $query->where(
            [
                'BorrowDevices.delivery_date LIKE' => "%".$inputData['delivery_date']."%"
            ]
            );
        }
        if (!empty($inputData['status'])){
            $query->where(
            [
                'BorrowDevices.status LIKE' => "%".$inputData['status']."%"
            ]
            );
        }
        //dd($query->all());
        $this->payload['payload']['BorrowDevices'] = $query->all();
        $this->response->body(json_encode($this->payload));
        return $this->response;
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
        $borrowDevice = $this->BorrowDevices->get($id, [
            'contain' => ['Approveds', 'Handovers', 'BorrowDevicesDetail']
        ]);

        $this->set('borrowDevice', $borrowDevice);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $borrowDevice = $this->BorrowDevices->newEntity();
        if ($this->request->is('post')) {
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
        //$this->set(compact('borrowDevice', 'borrowers', 'approveds', 'handovers'));
        $this->payload['payload']['BorrowDevices'] = $borrowDevice;
        $this->response->body(json_encode($this->payload));
        return $this->response;
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
            'contain' => []
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
}
