<?php
use Cake\Core\Configure;
$titletag=!empty($addon_title)?"{$base_title} - {$addon_title}":$base_title;
?><!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title>
  <?=$titletag?>
</title>
<?php
echo $this->Html->meta(
    'favicon.ico',
    '/favicon.ico',
    array('type' => 'icon')) ."\n";

echo $this->Html->css('conf-list') ."\n";

// jquery core
echo $this->Html->script('//code.jquery.com/jquery-1.10.2.min.js') ."\n";

// datepicker
echo $this->Html->css('//code.jquery.com/ui/1.11.1/themes/redmond/jquery-ui.css')."\n";
echo $this->Html->script('//code.jquery.com/ui/1.11.1/jquery-ui.js') ."\n";
echo $this->Html->script('datepicker') ."\n";  //configuration for conflist app
echo $this->Html->script('misc') ."\n";  //configuration for conflist app


// select2 - OLD
//echo $this->Html->css('select2') ."\n";
//echo $this->Html->css('https://cdn.jsdelivr.net/select2/3.4.8/select2.css') ."\n";
//echo $this->Html->script('https://cdn.jsdelivr.net/select2/3.4.8/select2.min.js') ."\n";

//select2 latest 2024-07-29
echo $this->Html->css('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css') ."\n";
echo $this->Html->script('https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js') ."\n";


echo $this->Html->script('select2_fields') ."\n";  //configuration for conflist app

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');

echo Configure::read('site.analytics');
//debug($tagids);
//debug($tagstring);
if (!isset($tagstring)) {
  $tagstring = '';
}
?>

</head>
<body>
<div id="container">
  <div id="header">
    <h1><?php //echo $this->Html->link(Configure::read('site.name'),Configure::read('site.home'));?></h1>
  </div>
  <div id="sub_header">
    <div id="menu">
      <?php echo $this->Html->link('Main List',array('controller' =>
      'conferences', 'action' => 'index'))?>
      |
      <?php 
      if (!isset($vtagstring)) $vtagstring='';
      echo $this->Html->link('New Announcement',array('controller' =>
      'conferences', 'action' => 'add', $vtagstring))?>
      |
      <?php echo $this->Html->link('Search',array('controller' =>
      'conferences', 'action' => 'search'))?>
      |
      <?php echo $this->Html->link('About',array('controller' =>
     'conferences', 'action' => 'about'))?>

    </div>
  </div>

  <div id="flashdiv">
    <?= $this->Flash->render() ?>
  </div>

  <!-- view content -->
  <div id="content">
    <?php echo $this->fetch('content'); ?>
  </div>
  <!-- footer -->
  <div id="footer">
    <!-- footer content -->
    <div style="text-align: left">
      <?php echo $this->Html->link(str_replace('http://www.','',Configure::read('site.host')),Configure::read('site.host'));?>
      <div id="admin_contact">
    Trouble? Comments?
    <?php echo $this->Html->link('Contact ' . Configure::read('site.host_name'),Configure::read('site.host_contact_url'));?>
      </div>
    </div>
  </div>
</div>



    <?php //echo $this->element('sql_dump'); ?>
</body>
</html>
