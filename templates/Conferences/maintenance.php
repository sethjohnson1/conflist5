<?php
use Cake\Core\Configure;
echo '<h1>'.$view_title.'</h1>';
?>

<?php
    if (Configure::read('readOnly')) {
        echo "
<p>The addition of new announcements is temporarily disabled due to an internal bug with confirmation emails.  We hope to have this resolved as soon as possible.</p>

<h2>Beginning of maintenance period</h2>
    <p>2025-08-11</p>


<h2>Expected end of maintenance period</h2>
    <p>Within one week</p>
";
    }
    else {
        echo "<h2>No active maintenance</h2>";
        echo "<p>The site is currently not under maintenance.  Please <a href='http://nilesjohnson.net/contact.html' target='blank'>contact Niles</a> if you experience any error or irregularity.</p>";
    }
?>

<h2>Donations</h2>

<p>The hosting and maintenance for Mathmeetings.net are fully voluntary and have never had external funding.
    We are accepting donations via <a href="https://ko-fi.com/niles25980">Niles's Ko-Fi account</a>.
  Many thanks to those who can support us this way!</p>

