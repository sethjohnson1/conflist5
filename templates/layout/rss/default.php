<?php
if (!isset($documentData)) {
    $documentData = array();
}
if (!isset($channelData)) {
    $channelData = array();
}
if (!isset($channelData['title'])) {
    $channelData['title'] = $title_for_layout;
}
//echo $this->fetch('content');
extract($channelData['atom:link']['attrib']);
?><rss xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title><?=$channelData['title']?></title>
        <link><?=$channelData['link']?></link>
        <description><?=$channelData['description']?></description>
        <language><?=$channelData['language']?></language>
        <atom:link href="<?=$href?>" rel="<?=$rel?>" type="<?=$type?>" />
<?=$this->fetch('content')?>
    </channel>
</rss><?php
