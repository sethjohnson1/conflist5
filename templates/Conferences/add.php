<?php
if (isset($edit)){
echo '<div class="conferences form">';
$addedit='Edit';
}
 else $addedit='New';
echo '<h1>'.$addedit.' Meeting Information</h1>';

echo $this->Form->create($conference);
echo $this->Form->submit('Submit');
echo "<br />";
if (isset($edit)){
	echo $this->Form->control('id');
	//echo $this->Form->input('edit_key', array('type'=>'hidden'));
}

echo $this->Form->control('title');
echo $this->Form->control('start_date');
echo $this->Form->control('end_date');
echo $this->Form->control('city', ['label'=>'City and State/Province']);

echo "\n"."<!-- country data from https://github.com/mledoze/countries licensed under Open Database License 1.0 -->\n";
echo $this->Form->control('country', ['type'=>'select', 'options'=>$countries, 'default'=>'country', 'after'=>'Type to narrow options','empty'=>'Choose country...']);
echo $this->Form->control('homepage', ['label'=>'Conference website']);
echo $this->Form->control('institution', ['label'=>'Host institution', 'after'=>'University, institute, etc.']);
echo $this->Form->control('meeting_type', ['after'=>'e.g. conference, summer school, special session, etc.']);
echo $this->Form->control('tags._ids', ['label'=>'Subject tags', 'after'=>'Arxiv subject areas.  Select one or more; type to narrow options', 'multiple'=>true, 'default'=>$tagids,'empty'=>false,'required']);
echo $this->Form->control('contact_name', ['label'=>'Contact Name(s), comma separated']);
echo $this->Form->control('contact_email', ['label'=>'Contact Email(s), comma separated', 'after'=>'never displayed publicly; confirmation and edit/delete codes will be sent to these addresses']);
echo $this->Form->control('contact_password',['tabindex'=>'-1','style'=>'display:none!important','autocomplete'=>'off','label'=>['text'=>'<span style="display:none!important;">Do not leave this field blank if you would like this entry to vanish</span>','escape'=>false]]);
echo $this->Form->control('description', ['label'=>['text'=>'Description: <br/><span style="font-size:80%;">Enter text, HTML, or <a href="http://daringfireball.net/projects/markdown/">Markdown</a>.</span>','escape'=>false], 'rows' => '10']);

echo '<div class="input"><p>Description Preview:</p><div class="wmd-preview"></div></div>';

// if (!(isset($edit) || $validCuratorcookie)) {
//   echo '<div id="ConferenceRecaptcha" class="required">';
//   echo $this->Form->label('recaptcha','Captcha task.');
//   echo '</div>';
// }
echo $this->Form->submit('Submit');
echo $this->Form->end();
if (isset($edit)):
echo '</div>';
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Conference.id'),$this->Form->value('Conference.edit_key')), [], __('Are you sure you want to delete "%s"?', $this->Form->value('Conference.title'))); ?></li>
		<li><?php echo $this->Html->link(__('List Conferences'), array('action' => 'index')); ?></li>
	</ul>
</div>
<?php endif ?>
<script type="text/javascript">
  // to set WMD's options programatically, define a "wmd_options" object with whatever settings
  // you want to override.  Here are the defaults:
  wmd_options = {
    // format sent to the server.  Use "Markdown" to return the markdown source.
    output: "HTML",

    // line wrapping length for lists, blockquotes, etc.
    lineLength: 40,

    // toolbar buttons.  Undo and redo get appended automatically.
    buttons: "bold italic | link blockquote code | ol ul heading hr",

    // option to automatically add WMD to the first textarea found.  See apiExample.html for usage.
    autostart: true
  };
</script>

<script type="text/javascript" src="<?=$this->Url->build('/')?>js/wmd/wmd.js"></script>
