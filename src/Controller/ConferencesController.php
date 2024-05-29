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
    public function index($tagstring=null)
    {
        $view_title='Upcoming Meetings';
        $query = $this->Conferences->find()->contain(['Tags'])->order(['start_date ASC'])->where(['end_date > '=>date('Y-m-d', strtotime("-1 week"))]);
        $stags=[];
        if ($tagstring!==null){
            //pass this to select box to select values
            $stags=explode('-',$tagstring);
            $where=[];
            //make a "where" array
            foreach ($stags as $stag) $where[]=['Tags.name LIKE'=>"{$stag}.%"];
            //can't figure out how to pass a param to that \Cake\ORM fx.. use a global!
            //perhaps this is better done as a custom finder
            global $conf_tag_where;
            $conf_tag_where=$where;
            
            $query=$this->Conferences->find()->matching('Tags',function (\Cake\ORM\Query $q){
                global $conf_tag_where;
                return $q->where(['OR'=>$conf_tag_where]);
            })->order(['start_date ASC'])->where(['end_date > '=>date('Y-m-d', strtotime("-1 week"))])->distinct(['Conferences.id'])->contain(['Tags']);
        }

        $conferences = $this->paginate($query);
        //debug($conferences);
        $qtags=$this->Conferences->Tags->find('all');
        $tags = $qtags->toArray();
        $tag_dropdown=[];
        foreach ($tags as $tag) {
            $key=$this->tag_shortname($tag->name);
            if ($key) $tag_dropdown[$key]=$tag->name;
        }
        //debug($conferences);
        $this->set(compact('conferences','tags','view_title','tag_dropdown','tagstring','stags'));
    }

    //$tagname= String, returns two letter 'at' from something like at.algebraic-topology
    function tag_shortname($tagname){
        $return=false;
        $tar=explode('.',$tagname);
        //is valid
        if (\is_array($tar) && count($tar)==2){
            $return=$tar[0];
        }
        return $return;
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
