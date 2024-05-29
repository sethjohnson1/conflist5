<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Controller\Controller\ModelAwareTrait;
/**
 * Conferences Controller
 *
 * @property \App\Model\Table\ConferencesTable $Conferences
 */
class ConferencesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event); //you're supposed to always have this, don't ask me why
       // $tags=$this->fetchModel('Tags');
       // $tags->recursive=0;
        $this->set('tagstring','');
        $this->set('tagids',array());
        //$this->Security->csrfCheck = false;
        //$this->Security->blackHoleCallback = 'blackhole';
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Conferences->find()->contain(['Tags'])->order(['start_date DESC']);
        $conferences = $this->paginate($query);

        $qtags=$this->Conferences->Tags->find('all');
        $tags = $this->paginate($qtags);
        //debug($conferences);
        $this->set(compact('conferences','tags'));
    }

    /**
     * View method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $conference = $this->Conferences->get($id, contain: ['Tags']);
        $this->set(compact('conference'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $conference = $this->Conferences->newEmptyEntity();
        if ($this->request->is('post')) {
            $conference = $this->Conferences->patchEntity($conference, $this->request->getData());
            if ($this->Conferences->save($conference)) {
                $this->Flash->success(__('The conference has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conference could not be saved. Please, try again.'));
        }
        $tags = $this->Conferences->Tags->find('list', limit: 200)->all();
        $this->set(compact('conference', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $conference = $this->Conferences->get($id, contain: ['Tags']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conference = $this->Conferences->patchEntity($conference, $this->request->getData());
            if ($this->Conferences->save($conference)) {
                $this->Flash->success(__('The conference has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conference could not be saved. Please, try again.'));
        }
        $tags = $this->Conferences->Tags->find('list', limit: 200)->all();
        $this->set(compact('conference', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $conference = $this->Conferences->get($id);
        if ($this->Conferences->delete($conference)) {
            $this->Flash->success(__('The conference has been deleted.'));
        } else {
            $this->Flash->error(__('The conference could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
