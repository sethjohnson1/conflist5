<?php
echo '<h1>'.$view_title.'</h1>';
?>


<p>MathMeetings.net provides a list of conferences and similar meetings in mathematics.
  There are a number of other such lists, but this list aims to be more complete by allowing <em>anyone at all</em> to add announcements.
  This is similar in spirit to a wiki, but the underlying software is focused on efficient storing, searching, and sorting of conference announcements.</p>

<p>Announcements are filtered by subject tags, and are curated by <a href=#curators>the volunteers listed below</a>.
  <em>Note</em>: This site restricts itself to meetings whose focus is mathematics.
  Announcements about more general meetings are typically not appropriate and may be deleted.</p>

<p>The site is developed by <a href="https://nilesjohnson.net" target="blank">Niles Johnson</a> with significant technical help and hosting by <a href="https://codytechnical.com">Seth Johnson of Cody Technical Services</a>.
  It began as a list for conferences in topology, but with the addition of subject tags we hope that it will be useful more generally.
  Please <a href="https://nilesjohnson.net/contact.html" target="blank">contact Niles</a> if you have further quesitons or comments!</p>


<h2>Adding Announcements</h2>

<div>
<p> To add an announcement, use the link at the top of the page.
  An email address is required so that announcements you post can be edited or deleted.
  To prevent abuse, a security token is stored as a browser cookie.</p>

<p>When you add an announcement, you will receive a message like the following:</p>

<div id="add-message">

<pre>Thanks for adding your announcement to MathMeetings.net.
The announcement data is copied below, and is also available at:
http://mathmeetings.net/conferences/view/28

If you need to edit or delete your announcement, use the unique edit/delete link:
http://mathmeetings.net/conferences/edit/28/YSZf1X2W

If you have any difficulties, questions, or comments, don't hesitate
to contact the curators:
http://mathmeetings.net/conferences/about#curators


best,
The Curators


Announcement Data:

My Interesting Conference!
2016-04-01 -- 2016-04-01

http://math.osu.edu

Contact: Niles Johnson
Institution: The Ohio State University
City: Columbus, OH
Country: USA
Meeting type: conference
Subject Tags:
  * at.algebraic-topology
  * ag.algebraic-geometry

Description:
This conference is going to be great!  See the website for more details.
</pre>
</div>

<p>If you need to update your announcement, use the links provided to access the edit or delete pages.
  Each announcement is assigned a random string which is required to edit or delete; this appears at the end of the links above and is generated when the announcement is created.
</p>
</div>


<h2 class="target" id="tags_about">Subject Tags</h2>

<div>
<p>With subject tags, we can include announcements from a broader range of fields while still allowing users to focus the conferences relevant for their field.
  When the tagging feature was first implemented, all announcements were tagged as 'at.algebraic-topology'.
  Future announcements are assigned a subject upon entry into the database.
  The subject tags are the <a href="http://arxiv.org/archive/math">arXiv.org math categories</a>.</p>

<p>The link to update tags on the home page is generated automatically by javascript.
 If you prefer not to use javascript, you can easily create the appropriate URL by hand.
  Simply use the 2-letter codes for each subject, separated by dashes.
  For example, to choose <span class="tag">at.algebraic-topology</span> and
<span class="tag">ct.category-theory</span>, use the following URL:</p>
<pre>
https://mathmeetings.net/at-ct
</pre>

<p>Note: Multiple tags are combined with an OR condition, meaning that you will see announcements which are tagged with any of the tags you select.
  For now, it does not seem useful to introduce more complex search logic.</p>

<p>Subject tags are supported on the main list, the rss feed, and the new announcement form.
  On the form, any active subject tags are used to set the default tags for the new announcement.</p>

</div>



<h2 class="target" id="xml_json_about">JSON and XML interfaces</h2>
<div>

<p>JSON and XML are two structured data formats which can be easily parsed by third-party software.
These interfaces are accessed by adding the extension '.json' or '.xml' after your subject tags.
 For example:
<?php echo $this->Html->link(
  'at-gt.json', array('controller'=>'Conferences', 'action'=>'at-gt.json'));?>
 or
<?php echo $this->Html->link(
  'ag-nt.xml', array('controller'=>'Conferences', 'action'=>'ag-nt.xml'));?>.
</p>
<p>
You can use these, for instance, to set up an alternate front for the announements on this site.
A crude demo can be found <a href="https://nilesjohnson.net/mathmeetings-front.html">here</a>.
Contact Niles if you are interested in additional features.</p>

<!--
<p>Here is a list of known alternative fronts.  Let us know if you maintain one that you would like added to the list!
</p>
<ul>
  <li><a href="">Kiran Kedlaya's </a></li>
  <li><a href=""></a></li>
</ul>
-->
</div>



<h2 class="target" id="cal_about">Calendar Links</h2>
<div>

<p> Links are provided to automatically import data from each
conference announcement into <a
href="http://en.wikipedia.org/wiki/Calendaring_software">calendaring
software</a>.  We have a direct link for Google Calendar, and an <a
href="http://en.wikipedia.org/wiki/ICalendar">iCalendar (.ics)</a>
formatted file for importing into other software.</p>

<!--
<p>New in version 2.1.3: An ICS feed is available, giving calendar
events for all announcements matching the given tag string.  A link to
the ICS feed is printed on the main index page, next to the RSS link.
</p>
-->

</div>

<h2 class="target" id="curators">Curators</h2>
<div>

<p> The people listed here have volunteered to help curate this site.
They help keep the list up-to-date by adding new announcements, if the
organizers haven't done so themselves.  They receive a copy of the
edit/delete keys for each announcement, and can help if you have any
trouble posting or updating your announcements.  </p>

<p>If you would like to volunteer, please <a
href="http://nilesjohnson.net/contact.html" target="blank">let Niles
know</a>!</p>

<h3>Arithmetic Geometry</h3>
<ul>
<li><a href="http://www.math.ucsd.edu/~kedlaya/" target="curator">Kiran Kedlaya</a>, UCSD</li>
</ul>


<!--
<h3>Algebraic Geometry, Complex Variables</h3>
<ul>
<li><a href="https://juliusro.people.uic.edu/wordpress/" target="curator">Julius Ross</a>, UIC</li>
</ul>

<h3>Algebraic Topology</h3>
<ul>
<li><a href="http://personal.denison.edu/~whiteda/" target="curator">David White</a>, Denison University</li>
</ul>

<h3>Differential Geometry</h3>
<ul>
<li><a href="http://www2.math.umd.edu/~yanir/" target="curator">Yanir A. Rubinstein</a>, UMD</li>
</ul>
-->

</div>

<h2>Searching</h2>
<div>
<p> A very rudimentary search form is now available at
  <?php echo $this->Html->link(
  'conferences/search', array('controller'=>'conferences', 'action'=>'search'));?>.
  Currently the search only performs simple date comparison and basic string matching in certain fields.
  Please <a href="http://nilesjohnson.net/contact.html" target="blank">let Niles know</a> if you have any requests for additional functionality.</p>
</div>

<h2>Countries List</h2>
<div>
<p>The list of countries provided when adding new announcements is from the <?php echo $this->Html->link('World countries','https://github.com/mledoze/countries');?> database, licensed under the <?php echo $this->Html->link('Open Database License 1.0','http://opendatacommons.org/licenses/odbl/1.0/')?>.
  The canonical names for our database are English spellings, but the entry box accepts a wide range of alternatives from the "<span style="font-family: mono">altSpellings</span>" field.</p>
</div>

<h2>Source Code</h2>
<div>
<p>
This list application was built with the <a
href="http://cakephp.org/">CakePHP</a> framework.  The source code is licensed
under GPL v3, and is hosted in a git repository on GitHub: <a
href="https://github.com/nilesjohnson/conference-list" target="github">conference-list</a>.</p>

<p>Want to contribute!?  <a
href="https://github.com/nilesjohnson/conference-list"
target="github">Browse the source</a>, have a look at the <a
href="https://github.com/nilesjohnson/conference-list/issues"
target="github">open issues</a>, and clone a working copy of the code.
<a href="http://nilesjohnson.net/contact.html" target="blank">Contact Niles</a> if you have further questions!</p> </div>
