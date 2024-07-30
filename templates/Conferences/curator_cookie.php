<h1 class="title">Set curator cookie</h1>
     <p>This fom lets you set a browser cookie so that your browser is recognized as a site curator.  With this cookie set, you will not need to complete the captcha task when adding new announcements.</p>

     <p>To set the cookie, enter the site admin key in the box below.  If you have lost the key, contact Niles.</p>

<?php

echo "<h2>".$cookieInfoHeader."</h2>";
echo $this->Form->create(null);
echo $this->Form->control('admin_key', array('label' => 'Admin Key'));
echo $this->Form->submit('Submit');
echo $this->Form->end();

?>
