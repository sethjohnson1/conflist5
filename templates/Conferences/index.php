<?php
use Cake\Core\Configure;
?>


<?php

// display search if requested
if (isset($searchVars)) {
echo '<h1>'.$view_title.'</h1>';

echo '<p>Currently the search only performs simple date comparison and basic
string matching in the indicated fields.  If you have more sophisticated search
needs, please <a href="http://nilesjohnson.net/contact.html" target="blank">let
Niles know</a>.</p>';

echo "<h2>Results Below: ".count($conferences)." Announcement" . (count($conferences) != 1 ? 's' : '') . "</h2>";

echo $this->Form->create(null);
$this->Form->setTemplates($form_wrapper);
echo "<br />";

echo $this->Form->control('Tag', array(
    'options'=>$tag_dropdown,
    'multiple',
    'label'=>'Subject tags',
    'name'=>'tag_select[]',
    'value'=>$tagarray,
));
echo $this->Form->control('after', array(
    'label'=>'Begins after',
    'value' => $searchVars['after'] ?? '',
    'type'=>'date',
    'div'=>'input datefield',
));
echo $this->Form->control('before', array(
    'label'=>'Begins before',
    'value' => $searchVars['before'] ?? '',
    'type'=>'date',
    'div'=>'input datefield',
));

echo $this->Form->control('title', array(
    'label' => 'Title contains',
    'value' => $searchVars['title'] ?? '',
));
echo $this->Form->control('country', array(
    'label'=>'Country contains',
    'value' => $searchVars['country'] ?? '',
    'type'=>'text',
));
echo $this->Form->control('institution', array(
    'label'=>'Host institution contains',
    'value' => $searchVars['institution'] ?? '',
));
echo $this->Form->control('meeting_type', array(
    'label'=>'Meeting type contains',
    'value' => $searchVars['type'] ?? '',
));
echo $this->Form->control('description', array(
    'label'=>'Description contains',
    'value' => $searchVars['description'] ?? '',
));

echo $this->Form->control('mod_after', array(
    'label'=>'Announcement posted or modified after',
    'value' => $searchVars['mod_after'] ?? '',
    'type'=>'date',
    'div'=>'input datefield',
    'after'=>'yyyy-mm-dd',
));
echo $this->Form->control('mod_before', array(
    'label'=>'Announcement posted or modified before',
    'value' => $searchVars['mod_before'] ?? '',
    'type'=>'date',
    'div'=>'input datefield',
    'before'=>'yyyy-mm-dd',
));

echo $this->Form->submit('Submit');
echo $this->Form->end();

echo "<hr/>";
} //end if


// else: default display
else {
?>

<div id="search_links">
<h2 style="margin: 0 0 1ex 0;">Choose a sublist of interest</h2>
<dl style="width:40ex;">
<dt><?php echo $this->Html->link(
  'Arithmetic Geometry', array('controller'=>'Conferences','action'=>'ag-nt'));?>
</dt>
<dd>
  <span class="tag">ag.algebraic-geometry</span>
  <span class="tag">nt.number-theory</span>
</dd>
<!--
<dt><?php echo $this->Html->link(
  'Commutative Algebra', array('controller'=>'Conferences','action'=>'ac-ag'));?>
</dt>
<dd>
  <span class="tag">ac.commutative-algebra</span>
  <span class="tag">ag.algebraic-geometry</span>
</dd>
-->
<dt><?php echo $this->Html->link(
  'Topology', array('controller'=>'Conferences','action'=>'at-gt'));?>
</dt>
<dd>
  <span class="tag">at.algebraic-topology</span>
  <span class="tag">gt.geometric-topology</span>
</dd>
<!--
<dt><?php echo $this->Html->link(
  'All', array('controller'=>'Conferences','action'=>''));?>
</dt>
<dd>
  <span style="font-size:90%;">View all announcements.</span>
</dd>
-->
</dl>

<h2>Or choose your own subject tags below</h2>
</div>


<div class="intro_text">

  <p>Welcome to MathMeetings.net!  This is a list for research
  mathematics conferences, workshops, summer schools, etc.  Anyone
  at all is welcome to add announcements.</p>



  <div class="new">
    <h2>Know of a meeting not listed here?  Add it now!</h2>
    <p>
    <?php echo $this->Html->link('New Announcement', array('action' => 'add',$tagstring), array('class' => 'button', 'id' => 'add-button'));?>
    </p>
  </div>
<!--
  <h4>Updates 2019-07</h4>
  <ul>
    <li>We're now authenticating email; this should decrease the chance that confirmation emails land in Spam or Junk folders.</li>
  </ul>
  <h4>Updates 2017-10</h4>
  <ul>
    <li>Secure connections (https) now activated and all traffic is automatically redirected to use https.  Thanks to <a href='https://letsencrypt.org/' target='le'>Let's Encrypt</a> for providing the certificate!</li>
    <li>Spam protection now provided by Google <a href="https://www.google.com/recaptcha" target='gr'>reCaptcha</a>.</li>
    <li>New <?php echo $this->Html->link(
  'json and xml interfaces', array('action'=>'about#xml_json_about'));?> for access by other software.</li>
  </ul>
  <h4>Updates 2016-01</h4>
  <ul>
    <li>Now filter announcements by subject tags</li>
    <li>Form for editing announcements is now the same as that for adding new announcements</li>
    <li>New 'view' page for each announcement, and announcement data in confirmation emails</li>
    <li>Select boxes improved with select2 (jquery)</li>
  </ul>

  <h4>Updates 2014-02-16</h4>

  <p>We've upgraded the AlgTop-Conf software to <a
  href="http://cakephp.org/" target="cake-blank">CakePHP 2.4.5</a> and
  <a href="http://www.php.net" target="php-blank">PHP 5.4</a>.  This involves
  substantial changes behind the scenes, but (hopefully!) minimal
  changes to the user interface.  If you notice something not working
  properly, please let Niles know.</p>
-->

  <p>Additional update notes are available in the <a href="https://github.com/nilesjohnson/conference-list" target="github">git repository</a> (GitHub).</p>

</div>


<hr class="top"/>
<h1 style="float:left;"><?php echo $view_title; ?></h1>

<div>
  <div style="float:right;">
<?php
  if ($tagstring) {
    echo $this->Html->link('ICS',array('controller'=>'Conferences','action'=>$tagstring.'.ics'));
  }
  else {
    echo $this->Html->link('ICS',Configure::read('site.home').'/conferences/index.ics');
  }
?>
  </div>

<?php
  echo $this->Form->create(null);
  //the multi-select happens magically because of the HABTM and the variable $tags
  /*
  echo $this->Form->input('Tag',array(
    'label'=>'Subject tags',
    'value'=>$tagids,
    'onchange'=>"updateTagLink('".$this->Html->link(array('controller'=>'Conferences','action'=>''))."');",
    'name'=>'tag_select',
    'after' => $this->Html->link(
      'Update tag selection', array('controller'=>'Conferences','action'=>$tagstring), array('id'=>'tag_link')),
    'div'=>array('style'=>'display:none','id'=>'tagSelectDiv')
  ));*/

  $form_wrapper = [
      'inputContainer' => '<div id="tagSelectDiv" style="display:none;" class=" {{type}}{{required}}">{{content}}</div>',
  ];
  $this->Form->setTemplates($form_wrapper);
  //sj new form
  echo $this->Form->control('Tag',[
    'options'=>$tag_dropdown,
    'multiple',
    'value'=>$tagarray,
    'label'=>'Subject Tags',
    'name'=>'tag_select',
    'onchange'=>"updateTagLink('".$this->Url->build(['controller'=>'Conferences','action'=>'index'],['fullBase'=>true])."');",

  ]);
  //disables the SecurityComponent
  //$this->Form->unlockField('Tag');
  echo $this->Form->end();

  echo $this->Html->link('Update tag selection', ['controller'=>'Conferences',$tagstring], ['id'=>'tag_link']);
?>
<script>
<!--
document.getElementById('tagSelectDiv').style.display = 'block';
//-->
</script>
<noscript>
<pre>A javascript feature to select tags appears here.</pre>
<p>See <a href="/conferences/about#tags_about">about subject tags</a> to select tags by hand.</p>
</noscript>
</div>

<?php } ?>

<?php $curr_subsort = Null; $new_subsort = Null; $subsort_counter = 0; echo '<div id="subsort_start">'; ?>
<?php
$site_url = Configure::read('site.home');
$site_name = Configure::read('site.name');

foreach ($conferences as $conference):
    $start_date=$conference['start_date'];
    // debug($start_date);
    /**
     * hacks for now
     * */
    $sort_condition=null;
if ($sort_condition == Null || $sort_condition == 'all') {
  //$datearray = explode("-",$conference['start_date']);
  //$new_subsort =  $months[(int)$datearray[1]]." ".$datearray[0];
    $new_subsort=$start_date->format('F Y');
 }
if ($sort_condition == 'country') {
  $new_subsort = $conference['country'];
 }
if ($new_subsort != $curr_subsort) {
  echo '</div>';
  $curr_subsort = $new_subsort;
  echo '<div class="subsort' . $subsort_counter . '">';
  echo '<h2>' . $new_subsort . '</h2>';
  $subsort_counter += 1;
  $subsort_counter = $subsort_counter % 2;
 }

// check if 'modified' is set and recent
if ($conference['modified'] && $conference['modified']->wasWithinLast('30 days')) {
$titleClass = "title recent";
$modInfo = '<span class="modinfo" style="padding-left: 1em; padding-right: 1em; font-size: 80%; font-style: italic; color:green;">[New]</span>';
}
else {
$titleClass = "title";
$modInfo = '';
}
echo '<h3 class="'.$titleClass.'">';

?>

<?php echo '<a href="'.
   $conference['homepage'].
   '">'.
   $modInfo.$conference['title'].
   '</a>'
   ;?>
</h3>
<div class="conference">

<div class="subject-tags">
<?php
  //debug($conference);
  foreach($conference['tags'] as $tag) {
    echo '<span class="tag">'.$tag['name']."</span>\n";
  }
?>
</div>

<div class="calendars">
<?php  echo
  $this->Html->link('Google calendar',
  $this->Gcal->gcal($conference),
  array('escape' => false,'class'=>'ics button'));
echo ' ';
echo
  $this->Html->link('iCalendar .ics',
  array('action'=>'view/'.$conference['id'].'.ics'),
  array('escape' => false,'class'=>'ics button'));
?>
</div>

<div class="dates">
   <?php echo $conference['start_date']." <small>through</small> ".$conference['end_date'];?>
</div>

<?php
      if (!empty($conference['institution'])) {
      	 echo "<div class=\"location\">";
      	 echo $conference['institution'];
	 echo "</div>";
      }

?>

<div class="location">
<?php
      echo $conference['city']."; ".$conference['country'];
?>
</div>

<div class="action">
<a  id="description_<?php echo $conference['id'];?>_plus" onclick="
   document.getElementById('description_<?php echo $conference['id'];?>').style.display='block';
   document.getElementById('description_<?php echo $conference['id'];?>_plus').style.display='none';
   document.getElementById('description_<?php echo $conference['id'];?>_minus').style.display='inline';
   return false;" href="#">Description</a>
<a  id="description_<?php echo $conference['id'];?>_minus" onclick="
   document.getElementById('description_<?php echo $conference['id'];?>').style.display='none';
   document.getElementById('description_<?php echo $conference['id'];?>_plus').style.display='inline';
   document.getElementById('description_<?php echo $conference['id'];?>_minus').style.display='none';
   return false;" href="#" style="display:none;"> - Description</a>
 |
<?php echo
  $this->Html->link('View entry',
  array('action'=>'view', $conference['id']));?>

<?php //print edit links
  if ($showEdit) {
    echo ' | <span class="edit-link">'.$this->Html->link('Edit',
    array('action'=>'edit', $conference['id']))."</span>";
  }?>


</div>

<div class="conference_minor" id="description_<?php echo $conference['id']?>">
<p>Meeting Type: <?php echo $conference['meeting_type']?></p>
<p>Contact: <?php echo
!$conference['contact_name'] ? 'see conference website' : $conference['contact_name']?></p>


<h3>Description</h3>
<div class="description"><?php echo
!$conference['description'] ? 'none' : $conference['description']
?></div>
</div>





</div>

<?php endforeach; ?>

</div>
