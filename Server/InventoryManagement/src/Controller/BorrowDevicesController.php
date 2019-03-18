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

        $borrowDevices = $this->paginate($this->BorrowDevices);

        // $this->set(compact('borrowDevices'));
        $this->payload['payload']['borrowDevices'] = $borrowDevices;
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
    // public function add()
    // {
    //     $borrowDevice = $this->BorrowDevices->newEntity();
    //     if ($this->request->is('post')) {
    //         $borrowDevice = $this->BorrowDevices->patchEntity($borrowDevice, $this->request->getData());
    //         if ($this->BorrowDevices->save($borrowDevice)) {
    //             $this->Flash->success(__('The borrow device has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The borrow device could not be saved. Please, try again.'));
    //     }
    //     $borrowers = $this->BorrowDevices->Borrowers->find('list', ['limit' => 200]);
    //     $approveds = $this->BorrowDevices->Approveds->find('list', ['limit' => 200]);
    //     $handovers = $this->BorrowDevices->Handovers->find('list', ['limit' => 200]);
    //     $this->set(compact('borrowDevice', 'borrowers', 'approveds', 'handovers'));
    // }

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
