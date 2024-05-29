
<div class="share-links">
  <div class="g-plusone" data-href="<? echo $conference['homepage']; ?>"></div>
  <div style="display: inline-block;"><a href="https://twitter.com/share" class="twitter-share-button" 
    data-text="<? echo $conference['title']; ?>"
    data-hashtags="ConferenceAnnouncement" 
    data-url="<? echo $conference['homepage'];?>">Tweet</a></div>
</div>


<h2 class="title">
<?php 
echo $this->Html->link($conference['title'], $conference['homepage']);
;?>
</h2>

<div class="subject-tags">
<?php
  foreach($conference['tags'] as $tag) {
    echo '<span class="tag">'.$tag['name']."</span>\n";
  }
?>
</div>

<div class="calendars" style="margin: 1ex;">
<?php  
echo
  $this->Html->link('Google calendar',
  $this->Gcal->gcal($conference),
  array('escape' => false,'class'=>'ics button'));

echo
  $this->Html->link('iCalendar .ics',['action'=>'view',$conference['id'],'_ext'=>'ics'], ['escape' => false,'class'=>'ics button']);
?>
</div>

<dl>
                
  <dt><?= __('Start Date') ?></dt>
  <dd><?= h($conference->start_date) ?></dd>


  <dt><?= __('End Date') ?></dt>
  <dd><?= h($conference->end_date) ?></dd>

  <dt><?= __('Institution') ?></dt>
  <dd><?= h($conference->institution) ?></dd>

  <dt><?= __('City') ?></dt>
  <dd><?= h($conference->city) ?></dd>

  <dt><?= __('Country') ?></dt>
  <dd><?= h($conference->country) ?></dd>

  <dt><?= __('Meeting Type') ?></dt>
  <dd><?= h($conference->meeting_type) ?></dd>

  <dt><?= __('Homepage') ?></dt>
  <dd><?= h($conference->homepage) ?></dd>

  <dt><?= __('Contact Name') ?></dt>
  <dd><?= h($conference->contact_name) ?></dd>

  <dt><?= __('Created') ?></dt>
  <dd><?= h($conference->created) ?></dd>

  <dt><?= __('Modified') ?></dt>
  <dd><?= h($conference->modified) ?></dd>

</dl>

<h2>Description</h2>
<div class="conference_minor" style="display:block">
<?php echo 
!$conference['description'] ? 'none' : $conference['description']
?>
</div>

<h2>Problems?</h2>
<p>
If you notice a problem with this entry, please contact 
<?php
echo "<a href=\"" . $this->Url->build('/') . "conferences/about#curators\">the curators</a> ";
?>
by email.
</p>

