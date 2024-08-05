<?php
/**
  confirmation email when new announcement is added
 */

echo 'Thanks for adding your announcement to '.$site_name.'.';
?>

The announcement data is copied below, and is also available at:
<?=$viewUrl?>


If you need to edit or delete your announcement, use the unique edit/delete link:
<?=$editUrl?>


If you have any difficulties, questions, or comments, don't hesitate
to contact the curators:
<?=$contactUrl?>




best,
The Curators


Announcement Data:

<?php
echo $content['title']."\n";
echo $content['start_date']." -- ".$content['end_date']."\n\n";

echo $content['homepage']."\n\n";

echo "Contact: ".$content['contact_name']."\n";

echo "Institution: ".$content['institution']."\n";
echo "City: ".$content['city']."\n";
echo "Country: ".$content['country']."\n";
echo "Meeting type: ".$content['meeting_type']."\n";
echo "Subject Tags:\n";
foreach($content['tags'] as $tag) {
    echo '  * '.$tag['name']."\n";
}
echo "\n";

echo "Description:\n";
echo !$content['description'] ? 'none' : strip_tags($content['description']);

?>


<?php
    //echo $content;
?>
