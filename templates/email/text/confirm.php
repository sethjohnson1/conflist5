<?php
/**
  confirmation email when new announcement is added
 */

echo '[FIXME thanks site name]';
// echo 'Thanks for adding your announcement to '.Configure::read('site.name').'.';
?>

The announcement data is copied below, and is also available at:
    [FIXME link]
<?php
// echo $this->Html->url(array('action'=>'view', $conference->$id), $full=true);
?>


If you need to edit or delete your announcement, use the unique edit/delete link:
    [FIXME link]
<?php
// echo $this->Html->url($url=array('action'=>'edit', $conference->$id, $conference->$edit_key), $full=true);
?>


If you have any difficulties, questions, or comments, don't hesitate
to contact the curators:
[FIXME curator link]
php echo
// $this->Html->url($url=array('action'=>'about#curators'), $full=true);




best,
The Curators


Announcement Data:

php
// echo $conference->$title."\n";
// echo $conference->$start_date." -- ".$conference->$end_date."\n\n";

// echo $conference->$homepage."\n\n";

// echo "Contact: ".$conference->$contact_name."\n";

// echo "Institution: ".$conference->$institution."\n";
// echo "City: ".$conference->$city."\n";
// echo "Country: ".$conference->$country."\n";
// echo "Meeting type: ".$conference->$meeting_type."\n";
// echo "Subject Tags:\n";
// foreach($conference['tags'] as $tag) {
//     echo '  * '.$tag['name']."\n";
// }
// echo "\n";

// echo "Description:\n";
// echo !$conference->$description ? 'none' : strip_tags($conference->$description);



php
//echo $this->Display->asText($conference['Conference']);

// echo $content;
// echo 'try two';
// echo '<pre>'; print_r($content); echo '</pre>';
