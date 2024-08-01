<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Controller\Controller\ModelAwareTrait;
use Cake\View\JsonView;
use Cake\View\XmlView;
use Cake\View\View;
use Cake\Core\Configure;
use Cake\Http\Cookie\Cookie;
use DateTime;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\NotImplementedException;
use Cake\Error\Debugger;
use Cake\Log\Log;

/**
 * Conferences Controller
 *
 * @property \App\Model\Table\ConferencesTable $Conferences
 */
class ConferencesController extends AppController
{
    /* placed here and the default view no longer works
    this enables .json and .xml but disables the regular view ??
    public function viewClasses(): array{
        return [JsonView::class, XmlView::class];
    }
*/

    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event); //you're supposed to always have this, don't ask me why
       // $tags=$this->fetchModel('Tags');
       // $tags->recursive=0;
        $this->set('tagstring','');
        $this->set('tagids',array());
        $this->set('base_title','Mathmeetings.net');
        $this->set('addon_title','');
        //$this->Security->csrfCheck = false;
        //$this->Security->blackHoleCallback = 'blackhole';
    }
    public function beforeRender(\Cake\Event\EventInterface $event){
        parent::beforeRender($event);
        $this->viewBuilder()->addHelper('Gcal');
        $this->viewBuilder()->addHelper('Ical');
        $serialized=['json','xml'];
        if (null!==$this->request->getAttribute('params')['_ext']){
            if (\in_array($this->request->getAttribute('params')['_ext'],$serialized)){
                $this->addViewClasses([JsonView::class, XmlView::class]);
                $this->viewBuilder()->setLayout('ajax');
             }
            //assumes you have ext/view.php (i.e. ics/view.php)
            else $this->viewBuilder()->setLayout($this->request->getAttribute('params')['_ext'].'/default');

        }

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($tagstring=null){
        $view_title='Upcoming Meetings';
        $query = $this->Conferences->find()->contain(['Tags'])->order(['start_date ASC'])->where(['end_date > '=>date('Y-m-d', strtotime("-1 week"))])->select($this->publicFields());
        $stags=[];
        if ($tagstring!==null){
            //pass this to select box to select values
            $stags=explode('-',$tagstring);
            $where=[];
            //make a "where" array
            foreach ($stags as $stag) $where[]=['Tags.name LIKE'=>"{$stag}.%"];
            //add the Tag match to the existing $query
            $query->matching('Tags',function (\Cake\ORM\Query $q) use($where){
                return $q->where(['OR'=>$where]);
            })->distinct(['Conferences.id']);
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

        if(null!==$this->request->getAttribute('params')['_ext']) {
            $file_ex=$this->request->getAttribute('params')['_ext'];
            if ($file_ex=='rss') $this -> render('rss/index');
            $this->set(compact('conferences'));
            $this->viewBuilder()->setOption('serialize', ['conferences']);
            //$this -> render('ajax');
        }
    }

    //returns array of fields to select, omitting sensitive data
    function publicFields(){
        return [
            'title',
            'start_date',
            'end_date',
            'institution',
            'city',
            'country',
            'meeting_type',
            'subject_area',
            'homepage',
            'contact_name',
            'description',
            'created',
            'modified',
            'id',
        ];
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
    public function view($id = null){
        $conference = $this->Conferences->get($id, contain: ['Tags'], fields: $this->publicFields());
        $addon_title=\strip_tags($conference->title);
        $this->set(compact('conference','addon_title'));

        //there must be a better way to figure out this is an ics..
        if (null!==$this->request->getAttribute('params')['_ext']){
            $file_ex=$this->request->getAttribute('params')['_ext'];
            if ($file_ex=='ics') $this -> render('ics/view');
            else{

                $this->set(compact('conference'));
                $this->viewBuilder()->setOption('serialize', ['conference']);
            }
        }

    }

    public function admin($id = null){
        // do everything for standard view
        $this->view($id);
        // check if cookie is set and correct
        $cookie = $this->request->getCookie('curator_cookie');
        if ($cookie == Configure::read('site.curator_cookie')) {
            // send the edit link to be displayed
            $editKey= $this->Conferences->get($id, fields: ['edit_key']);
            $editLink = '/conferences/edit/'.$id.'/'.$editKey['edit_key'];
            $this->set(compact('editLink'));
        }
        // render the standard view
        $this->render('/Conferences/view');
    }



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(){
        $conference = $this->Conferences->newEmptyEntity();
        $countries=$this->loadCountries();
        $error='Unspecified error has occurred';
        //debug($countries);
        if ($this->request->is('post')) {
            //debug($this->request->getData());
            //check dates
            try{
                $sd=new DateTime($this->request->getData()['start_date']);
                $ed=new DateTime($this->request->getData()['end_date']);
                if ($sd>$ed) $error='Start date cannot be after end date.';
                else $error=false;
            }
            catch (Exception $e){
                $error='Dates could not be parsed. Please contact us if you continue to receive this error.';
            }
            if (!$error){
                $conference = $this->Conferences->patchEntity($conference, $this->request->getData());
                if ($this->Conferences->save($conference)) {
                    $this->Flash->success(__('The conference has been saved.'));
                    return $this->redirect(['action' => 'index']);
                }
                else $error='The conference could not be saved. Please, try again.';
            }

            $this->Flash->error(__($error));
        }
        $tags = $this->Conferences->Tags->find('list', limit: 200)->all();
        $this->set(compact('conference', 'tags','countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null,$key=null)
    {
        $conference = $this->Conferences->get($id, contain: ['Tags']);
        if ($key!=$conference->edit_key) throw new NotFoundException(__('Invalid conference'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conference = $this->Conferences->patchEntity($conference, $this->request->getData());
            if ($this->Conferences->save($conference)) {
                $this->Flash->success(__('The conference has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The conference could not be saved. Please, try again.'));
        }
        $tags = $this->Conferences->Tags->find('list', limit: 200)->all();
        $countries=$this->loadCountries();
        $this->set(compact('conference', 'tags','countries'));
        $this->set('edit',1);
        $this->render('add');
    }

    /**
     * Delete method
     *
     * @param string|null $id Conference id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null){
        $this->request->allowMethod(['post', 'delete']);
        $conference = $this->Conferences->get($id);
        if ($this->Conferences->delete($conference)) {
            $this->Flash->success(__('The conference has been deleted.'));
        } else {
            $this->Flash->error(__('The conference could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function loadCountries($file = "../webroot/files/countries/countries.json"){
        $return=[];
        $tmpCountries = [];
        //not necessary, just use "empty" value on Form control
        //$tmpCountries['country'] =  "Country...";

        if (($handle = fopen($file, "r")) !== FALSE) {
            $countries_data=json_decode(fread($handle,filesize($file)));
            if (null!==$countries_data){
                foreach ($countries_data as $cobj){
                    if (!isset($tmpCountries[$cobj->region])) $tmpCountries[$cobj->region]=[];

/* these don't work; figure out how to use data from alternate spellings
                    if ($cobj->name->common=='United States') $tmpCountries[$cobj->region]['USA']=$cobj->name->common;
                    elseif ($cobj->name->common=='United Kingdom') $tmpCountries[$cobj->region]['UK']=$cobj->name->common;
*/

                    //simple original way
                    //$tmpCountries[$cobj->region][$cobj->name->common]=$cobj->name->common;

                    //add alt spellings to value, then use select2 to format results using id (key) instead of val
                    $tmpCountries[$cobj->region][$cobj->name->common]=$cobj->name->common.' ('.implode(', ',$cobj->altSpellings).')';

                }
            }
            $tmpCountries['Virtual'] =  [];
            $tmpCountries['Virtual']["Online"] = "Online";
            //Debugger::dump($tmpCountries['Americas']);
            //debug($tmpCountries);
            $return=$tmpCountries;
            fclose($handle);
        }
        return $return;
    }

    public function curatorCookie() {
        $cookie = $this->request->getCookie('curator_cookie');
        if ($cookie == Configure::read('site.curator_cookie')) {
            $cookieInfoHeader = 'Curator cookie is set!';
        }
        else {
            $cookieInfoHeader = 'Enter admin key to set cookie.';
        }
        $thisData = $this->request->getData();
        if (!empty($thisData)) {
            if ($thisData['admin_key'] == Configure::read('site.admin_key')) {
                $this->response = $this->response->withCookie(Cookie::create(
                    'curator_cookie',
                    Configure::read('site.curator_cookie'),
                    [
                        'expires' => new DateTime('+1 year'),
                        'path' => '/',
                        'secure' => true,
                        'httponly' => true,
                    ]
                ));

                $cookieInfoHeader = 'Curator cookie is set!';
                $this->Flash->success(__('Curator cookie set!'));
                // return $this->redirect(['action' => 'index']);
            }
            else {
            $this->Flash->error(__('incorrect key'));
            }
        }
        $this->set(compact('cookieInfoHeader'));
    }


}
