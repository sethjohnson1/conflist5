<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ConferencesTags Controller
 *
 * @property \App\Model\Table\ConferencesTagsTable $ConferencesTags
 */
class ConferencesTagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ConferencesTags->find()
            ->contain(['Conferences', 'Tags']);
        $conferencesTags = $this->paginate($query);

        $this->set(compact('conferencesTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Conferences Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $conferencesTag = $this->ConferencesTags->get($id, contain: ['Conferences', 'Tags']);
        $this->set(compact('conferencesTag'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $conferencesTag = $this->ConferencesTags->newEmptyEntity();
        if ($this->request->is('post')) {
            $conferencesTag = $this->ConferencesTags->patchEntity($conferencesTag, $this->request->getData());
            if ($this->ConferencesTags->save($conferencesTag)) {
                $this->Flash->success(__('The conferences tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conferences tag could not be saved. Please, try again.'));
        }
        $conferences = $this->ConferencesTags->Conferences->find('list', limit: 200)->all();
        $tags = $this->ConferencesTags->Tags->find('list', limit: 200)->all();
        $this->set(compact('conferencesTag', 'conferences', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Conferences Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $conferencesTag = $this->ConferencesTags->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conferencesTag = $this->ConferencesTags->patchEntity($conferencesTag, $this->request->getData());
            if ($this->ConferencesTags->save($conferencesTag)) {
                $this->Flash->success(__('The conferences tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conferences tag could not be saved. Please, try again.'));
        }
        $conferences = $this->ConferencesTags->Conferences->find('list', limit: 200)->all();
        $tags = $this->ConferencesTags->Tags->find('list', limit: 200)->all();
        $this->set(compact('conferencesTag', 'conferences', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Conferences Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $conferencesTag = $this->ConferencesTags->get($id);
        if ($this->ConferencesTags->delete($conferencesTag)) {
            $this->Flash->success(__('The conferences tag has been deleted.'));
        } else {
            $this->Flash->error(__('The conferences tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
