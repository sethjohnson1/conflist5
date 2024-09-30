<?php
use Cake\Core\Configure;
$this->set('documentData',['xmlns:atom' => 'http://www.w3.org/2005/Atom']);

$this->set('channelData',[ 
    'title' => __(Configure::read('site.name')." Announcements"),
    'link' => $this->Url->build('/',['fullBase'=>true]),
    'description' => __("Upcoming meetings."),
    'language' => 'en-us',
    'atom:link' =>[ 
  		'attrib' =>[ 
		    'href' => Configure::read('site.home')."/conferences/index.rss",
 		    'rel' => 'self',
		    'type' => 'application/rss+xml'
  			]
    	]
  ]
);
\ob_start();
foreach ($conferences as $conference) :
	$bodyText = $conference['start_date']." <small>through</small> ".$conference['end_date'];
  $bodyText .= ", ".$conference['city']."; ".$conference['country'];
  $bodyText = h(strip_tags($bodyText));
?>		<item>
			<title><?=\_clean_for_rss($conference['title'])?></title>
			<link><?=\_clean_for_rss($conference['homepage'])?></link>
			<guid isPermaLink="true"><?=\_clean_for_rss($conference['homepage'])?></guid>
			<description><?=\_clean_for_rss($bodyText)?></description>
			<enclosure length="<?=strlen($this->Ical->vcal([$conference]))?>" type="text/calendar" url="<?=$this->Url->build(['controller'=>'conferences','action'=>'view',$conference['id'],'_ext'=>'ics'],['fullBase'=>true])?>" />
		</item>
<?php	
endforeach;
echo \ob_get_clean();

function _clean_for_rss($string){
	return preg_replace('/[^(\x20-\x7F)\x0A]*/','', $string);
}
?>