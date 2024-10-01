<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Controller\Controller\ModelAwareTrait;
use Cake\View\JsonView;
use Cake\View\XmlView;
use Cake\View\View;
use Cake\View\UrlHelper;
use Cake\Core\Configure;
use Cake\Http\Cookie\Cookie;
use DateTime;
use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\Mailer\Mailer;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\NotImplementedException;
use Cake\Error\Debugger;
use Cake\Log\Log;
use Cake\Routing\Router;


Date::setToStringFormat('yyyy-MM-dd');
FrozenDate::setToStringFormat('yyyy-MM-dd');

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
        //$this->viewBuilder()->addHelper('Rss');
        $this->viewBuilder()->addHelper('Url', [
            'className' => 'Urloverride'
        ]);

        
        $serialized=['json','xml'];
        $rss_actions=['index','search'];
        if (!empty($this->request->getAttribute('params')['_ext'])){
            if (\in_array($this->request->getAttribute('params')['_ext'],$serialized)){
                $this->addViewClasses([JsonView::class, XmlView::class]);
                $this->viewBuilder()->setLayout('ajax');
             }
             elseif ($this->request->getAttribute('params')['_ext']==='rss' && \in_array($this->request->getAttribute('params')['action'],$rss_actions)){
                    $this->response = $this->response->withType('application/xml');
                    $this->viewBuilder()->setLayout('rss/default');
             }
             elseif ($this->request->getAttribute('params')['_ext']==='ics'){
                $this->response = $this->response->withType('text/calendar');
                $this->viewBuilder()->setLayout('ics/default');
             }
             else throw new NotFoundException();


        }
        //names of actions requiring custom template. placing here prevents validation errors
        $needs_form_template=['add','edit','search'];
        if (\in_array($this->request->getParam('action'),$needs_form_template)){
            $form_wrapper=$this->setFormTemplate();
            $this->set(compact('form_wrapper'));
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($tagstring=null){
        //prevent these values getting passed as the tagarray
        $skip_tags=[
            'conferences',
            'index',
            'curatorCookie',
        ];
        $view_title='Upcoming Meetings';
        // conditions for default list view
        $conditions = ['end_date > '=>date('Y-m-d', strtotime("-1 week"))];
        if ($tagstring !== null && !\in_array($tagstring,$skip_tags)) {
            $tagarray = explode('-',$tagstring);
        }
        else {
            $tagarray = null;
        }

        return $this->renderList($view_title,$conditions,$tagarray);
    }

    public function search() {
        $searchVars = [];
        $tagarray = null; //default
        $view_title='Search Announcements';
        $new_query=[];
        //if POST then build a search query and redirect
        if ($this->request->is(['post'])) {
            foreach ($this->request->getData() as $field=>$value){
                if (!\in_array($field,$this->allowedSearchParams())) continue;
                if (empty($value) && $field!=='after') continue; //let after be empty
                $new_query[$field]=$value;
            }
            return $this->redirect(['action' => 'search','?'=>$new_query]);
        }

        // debug($this->request->getQuery());

        // defaults
        if (!isset($this->request->getQuery()['after'])){
            $searchVars['after'] = new DateTime('-1 week');
            $conditions = array('start_date >' => $searchVars['after']);  
        }
        

        // process querystring from url
        foreach ($this->request->getQuery() as $field => $value) {
            if (!\in_array($field,$this->allowedSearchParams())) continue;
            if ($value != '') {
                $searchVars[$field] = $value;
                if ($field == 'before') {
                    $conditions['start_date <'] = $value;
                }
                elseif ($field == 'after') {
                    $conditions['start_date >'] = $value;
                }
                elseif ($field == 'mod_before') {
                    $conditions['modified <'] = $value;
                }
                elseif ($field == 'mod_after') {
                    $conditions['modified >'] = $value;
                }
                elseif ($field == 'tag_select') {
                    //'tag_select' will be an array
                    $tagarray = $value;
                }
                else {
                    $conditions[$field.' LIKE'] = '%'.$value.'%';
                }
		//debug($conditions);
            }
        }
        // variables for search view only
        $this->set(compact('searchVars',));

        return $this->renderList($view_title,$conditions,$tagarray);
    }

    function renderList($view_title,$conditions,$tagarray) {
        /*
          process query for either list or search views
          $tagarray should be null or an array of short tag names (ac, ag, at, etc.)
        */
        $qtags=$this->Conferences->Tags->find('all');
        $tags = $qtags->toArray();
        $tag_dropdown=[];
        $valid_tag_checker=[];
        foreach ($tags as $tag) {
            $key=$this->tag_shortname($tag->name);
            if ($key) $tag_dropdown[$key]=$tag->name;
            $valid_tag_checker[]=$key;
        }
        $query = $this->Conferences->find()
            ->contain('Tags')
            ->where($conditions)
            ->order(['start_date ASC'])
            ->select($this->publicFields());

        //make a validated tagstring
        $vtagstring='';
        if ($tagarray!==null){
            $found_valid=[];//sj - if not at least one valid tag throw a NotFound
            $where=[];
            //make a "where" array
            foreach ($tagarray as $stag){
               $where[]=['Tags.name LIKE'=>"{$stag}.%"];
               //make array of valid tags
               if (\in_array($stag,$valid_tag_checker)) $found_valid[]=$stag;
            }
            if (empty($found_valid)) throw new NotFoundException();
            $vtagstring=implode('-',$found_valid);
            //add the Tag match to the existing $query
            $query->matching('Tags',function (\Cake\ORM\Query $q) use($where){
                return $q->where(['OR'=>$where]);
            })->distinct(['Conferences.id']);
        }

        //debug($query);

        $conferences = $this->paginate($query,['limit'=>100]);
        // debug($conferences);


        //debug($conferences);

        if(null!==$this->request->getAttribute('params')['_ext']) {
            $file_ex=$this->request->getAttribute('params')['_ext'];
            // if ($file_ex=='rss') $this -> render('rss/index');
            $this->set(compact('conferences'));
            $this->viewBuilder()->setOption('serialize', ['conferences']);
            //$this -> render('ajax');
        }

        // show edit button if cookie is set
        $cookie = $this->request->getCookie('curator_cookie');
        if ($cookie == Configure::read('site.curator_cookie')) {
            $showEdit = true;
        }
        else {
            $showEdit = false;
        }

        // variables for both list and search view
        
        $this->set(compact('view_title',
                           'conferences',
                           'tags',
                           'tagarray',
                           'tag_dropdown',
                           'showEdit',
                           'vtagstring',
        ));
        if ($this->request->getAttribute('params')['_ext']==='rss') return $this->render('rss/index');
        return $this->render('index');
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

    function allowedSearchParams(){
        return [
            'tag_select',
            'after',
            'before',
            'title',
            'country',
            'institution',
            'meeting_type',
            'after',
	    'before',
	    'mod_before',
	    'mod_after',

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

    function tag_name_from_id($tagid) {
        $t = $this->Tag->find('first',array('conditions'=>array('Tag.id'=>$tagid)));
        return $t['Tag']['name'];
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

    public function about() {
        $view_title='About';
        $this->set(compact('view_title'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(){
        $conference = $this->Conferences->newEmptyEntity();
        $countries=$this->loadCountries();
        $time_error='Unspecified error has occurred';
        //debug($countries);
        if ($this->request->is('post')) {
            //patchEntity right away so we can check hasErrors()
            $conference = $this->Conferences->patchEntity($conference, $this->request->getData());

            //HONEYPOT check
            if (isset($this->request->getData()['contact_password']) && !empty($this->request->getData()['contact_password'])){
                // adds entry in logs/debug.log, with 'info' prefix
                Log::write('info',
                           'Honeypot trigger: title={title}, email={email}',
                           ['title' => $this->request->getData()['title'],
                            'email' => $this->request->getData()['contact_email']
                           ]);
                //do nothing but pretend to save.
                $this->Flash->success(__('Action completed.'));
                return $this->redirect(['action' => 'index']);
            }

            //check dates
            try{
                $sd=new DateTime($this->request->getData()['start_date']);
                $ed=new DateTime($this->request->getData()['end_date']);
                if ($sd>$ed) $time_error='Start date cannot be after end date.';
                else $time_error=false;
            }
            catch (Exception $e){
                $time_error='Dates could not be parsed. Please contact us if you continue to receive this error.';
            }

            if (!$time_error && !$conference->hasErrors()){
                //$conference = $this->Conferences->patchEntity($conference, $this->request->getData());

                return $this->saveAndSend($conference);
            }
            else{
                //display all errors
                if ($time_error) $this->Flash->error(__($time_error));
                if ($conference->hasErrors()){
                    foreach ($conference->getErrors() as $cerr){
                        $this->Flash->error(__('Validation failed. Please check your entries and try again.'));
                        //$cerr is a validatorName=>error message, so loop here too
                        //foreach ($cerr as $validator_rule=>$errmessage) $this->Flash->error(__($errmessage));
                    }
                }
            }
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
        if ($key!=$conference->edit_key) {
            $cookie = $this->request->getCookie('curator_cookie');
            if ($cookie != Configure::read('site.curator_cookie')) {
                throw new NotFoundException(__('Invalid conference'));
            }
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $conference = $this->Conferences->patchEntity($conference, $this->request->getData());
            return $this->saveAndSend($conference);
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
    public function delete($id = null,$key=null){
        $this->request->allowMethod(['post', 'delete']);
        $conference = $this->Conferences->get($id);
        if (($key!==null && $conference->edit_key==$key) //check edit key
            && $this->Conferences->delete($conference)) {
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

    public function saveAndSend($conference) {
        /*
         * helper function to save data and send email
         * ends with redirect
         */
        // verify that all data saves
        if ($this->Conferences->save($conference)) {
            $this->Flash->success(__('The announcement has been saved.'));

            $mailer = $this->prepEmail($conference->id);
            if ($mailer->deliver()) {
                $this->Flash->success(__('Confirmation emails have been sent.'));
            }
            return $this->redirect(['action' => 'index']);
        }
        // else: save has failed
        else $this->Flash->error(__('The announcement could not be saved. Please, try again or contact the curators.'));
    }

    public function getEmailer() {
        // function to return emailer, so we can replace it during tests
        $mailer = new Mailer();
        $mailer->viewBuilder()
            ->setTemplate('confirm')
            ->setLayout('default');
        // maybe set transport stuff here??
        // trying to load from EmailTransport config
        $mailer->setTransport('default')
            ->setFrom(Configure::read('site.confirmation_from'))
            ->setSender(Configure::read('site.confirmation_from'));

        // idea: maybe take an argument to choose live, test, nosend, etc?
        return $mailer;
    }

    public function prepEmail($id) {
        // everything to prepare email for sending
        // or for viewing during testing

        // load data by id number; this function only called after successful save
        $conference = $this->Conferences->get($id, contain: ['Tags']);
        $this->set(compact('conference'));
        // debug($conference);

        $mailer = $this->getEmailer();
        $mailer->setEmailFormat('text');

        //set variables
        $viewUrl = Router::url(['controller' => 'Conferences',
                                'action' => 'view',
                                $conference->id,
                                '_full' => true
        ]);
        $editUrl = Router::url(['controller' => 'Conferences',
                                'action' => 'edit',
                                $conference->id,
                                $conference->edit_key,
                                '_full' => true
        ]);
        $contactUrl = Router::url(['controller' => 'Conferences',
                                   'action' => 'about',
                                   '#' => 'curators'
        ],true);

        $mailer->setViewVars(['site_name'=>Configure::read('site.name'),
                              'viewUrl' => $viewUrl,
                              'editUrl' => $editUrl,
                              'contactUrl' => $contactUrl,
                              'content'=>$conference,
        ]);

        //gather and set values from $conference data
        $mailer->setSubject($conference->title);
        $to_array = preg_split("/[\s,]+/",$conference->contact_email);
        $mailer->setTo($to_array); //does setTo still take an array argument??


        //gather values from config
        $admin_email = Configure::read('site.admin_email');
        // cc: addresses from config for matching tags
        $cc_array = [];
        foreach($conference->tags as $tag) {
            $t = explode('.',$tag['name'])[0];
            if (array_key_exists($t,$admin_email)) {
                $cc_array = array_merge($cc_array,$admin_email[$t]);
            }
        }
        $mailer->setCc($cc_array); //does setCc take an array argument?
        // bcc: addresses in config 'site.admin_email'
        $admin_email = Configure::read('site.admin_email');
        $mailer->setBcc($admin_email['all']);

        return $mailer;
    }

    public function testEmailSend($id) {
        // a hack to test sending of emails
        // visit url with id number
        // should send email filled with info from that conference id;
        // fields To, Cc, Bcc are reset to site.test_email address
        // comment lines below to also reset cc and bcc lines
        //
        // protected from public by curator cookie
        $cookie = $this->request->getCookie('curator_cookie');
        if ($cookie == Configure::read('site.curator_cookie')) {
            $conference = $this->Conferences->get($id, contain: ['Tags']);

            $mailer = $this->prepEmail($id);
            //do something here

            //reset to for testing
            $testEmail = Configure::read('site.test_email');
            $mailer->setTo($testEmail);
            $mailer->setCc($testEmail); // clear previously set cc
            $mailer->setBcc($testEmail); // clear previously set bcc
            // debug($conference);
            // debug($testEmail);
            // debug($mailer);

            //NOTE: this doesn't do much because the SocketException is caught in the framework before this
            try{
                $mailer->deliver();
            }
            catch (Exception $e){
                debug($e);
            }

            if ($mailer->deliver()) {
                if (\is_array($testEmail)) $testEmail=implode(', ',$testEmail);
                $this->Flash->success(__('email sent to '.$testEmail));
            }
            return $this->render('view');
        }
        else {
            throw new NotFoundException(__('Invalid conference'));
        }
    }

    function setFormTemplate() {
        // there must be a better way to do this,
        // but I don't know what it is;
        // making a whole new helper seems too much
        $form_wrapper = [
            'inputContainer' => '<div class="input {{type}}{{required}}">{{content}}<span class="after-text">{{after}}</span></div>',
        ];
        return $form_wrapper;
        //$this->set(compact('form_wrapper'));
    }

} // close class
