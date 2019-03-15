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
        //$devices = $this->Devices->find('all');
        $devices = $this->paginate($this->Devices);
        $this->payload['payload']['categories'] = $devices;
        $this->response->body(json_encode($this->payload));
        return $this->response;

    }

    public function view($id)
    {
        $devices = $this->Devices->get($id);
        $this->payload['payload']['categories'] = $devices;
        $this->response->body(json_encode($this->payload));
        return $this->response;

    }

    public function add()
    {
        $devices = $this->Devices->newEntity($this->request->getData());
        if ($this->Devices->save($devices)) {
            $message = 'Saved';
        } else {
            $message = 'Error';
        }
        $this->payload['payload']['devices'] = $devices;
        $this->response->body(json_encode($this->payload));
        return $this->response;
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
        $this->payload['payload']['devices'] = $devices;
        $this->response->body(json_encode($this->payload));
        return $this->response;
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
