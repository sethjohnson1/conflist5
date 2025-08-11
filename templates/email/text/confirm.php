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

p.s. We are now accepting donations toward our growing server and maintenance costs. Those who wish to do so can donate via Niles's Ko-Fi account:

  https://ko-fi.com/niles25980

Many thanks to those who can support us this way!





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





