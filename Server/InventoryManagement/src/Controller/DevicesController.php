<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Devices Controller
 *
 *
 * @method \App\Model\Entity\Device[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
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
        $devices = $this->Devices->find('all');
        $this->set([
            'devices' => $devices,
            '_serialize' => ['devices']
        ]);
    }

    public function view($id)
    {
        $devices = $this->Devices->get($id);
        $this->set([
            'devices' => $devices,
            '_serialize' => ['devices']
        ]);
    }

    public function add()
    {
        $devices = $this->Devices->newEntity($this->request->getData());
        if ($this->Devices->save($devices)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        // $this->set([
        //     'message' => $message,
        //     'devices' => $recipe,
        //     '_serialize' => ['message', 'devices']
        // ]);

        $this->payload['payload'] = ['test' => '32432342234'];
    }

    public function edit($id)
    {
        $devices = $this->Devices->get($id);
        if ($this->request->is(['post', 'put'])) {
            $devices = $this->Devices->patchEntity($devices, $this->request->getData());
            if ($this->Devices->save($devices)) {
                $message = 'Saved';
            } else {
                $message = 'Error';
            }
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }

    public function delete($id)
    {
        $devices = $this->Devices->get($id);
        $message = 'Deleted';
        if (!$this->Devices->delete($devices)) {
            $message = 'Error';
        }
        $this->set([
            'message' => $message,
            '_serialize' => ['message']
        ]);
    }
}
