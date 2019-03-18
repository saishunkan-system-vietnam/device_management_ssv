<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BorrowDevicesDetail Controller
 *
 * @property \App\Model\Table\BorrowDevicesDetailTable $BorrowDevicesDetail
 *
 * @method \App\Model\Entity\BorrowDevicesDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BorrowDevicesDetailController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['BorrowDevices']
        // ];
        $borrowDevicesDetail = $this->paginate($this->BorrowDevicesDetail);

        //$this->set(compact('borrowDevicesDetail'));
        $this->payload['payload']['borrowDevicesDetail'] = $borrowDevicesDetail;
        $this->response->body(json_encode($this->payload));
        return $this->response;
    }

    /**
     * View method
     *
     * @param string|null $id Borrow Devices Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $borrowDevicesDetail = $this->BorrowDevicesDetail->get($id, [
            'contain' => ['BorrowDevices']
        ]);

        $this->set('borrowDevicesDetail', $borrowDevicesDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $borrowDevicesDetail = $this->BorrowDevicesDetail->newEntity();
        if ($this->request->is('post')) {
            $borrowDevicesDetail = $this->BorrowDevicesDetail->patchEntity($borrowDevicesDetail, $this->request->getData());
            if ($this->BorrowDevicesDetail->save($borrowDevicesDetail)) {
                $this->Flash->success(__('The borrow devices detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The borrow devices detail could not be saved. Please, try again.'));
        }
        $borrowDevices = $this->BorrowDevicesDetail->BorrowDevices->find('list', ['limit' => 200]);
        $this->set(compact('borrowDevicesDetail', 'borrowDevices'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Borrow Devices Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $borrowDevicesDetail = $this->BorrowDevicesDetail->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $borrowDevicesDetail = $this->BorrowDevicesDetail->patchEntity($borrowDevicesDetail, $this->request->getData());
            if ($this->BorrowDevicesDetail->save($borrowDevicesDetail)) {
                $this->Flash->success(__('The borrow devices detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The borrow devices detail could not be saved. Please, try again.'));
        }
        //$borrowDevices = $this->BorrowDevicesDetail->BorrowDevices->find('list', ['limit' => 200]);
        //$this->set(compact('borrowDevicesDetail', 'borrowDevices'));
        $this->payload['payload']['borrowDevicesDetail'] = $borrowDevicesDetail;
        $this->response->body(json_encode($this->payload));
        return $this->response;
    }

    /**
     * Delete method
     *
     * @param string|null $id Borrow Devices Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $borrowDevicesDetail = $this->BorrowDevicesDetail->get($id);
        if ($this->BorrowDevicesDetail->delete($borrowDevicesDetail)) {
            $this->Flash->success(__('The borrow devices detail has been deleted.'));
        } else {
            $this->Flash->error(__('The borrow devices detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
