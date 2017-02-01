<html>
<head>
</head>
<body>
<?php

require_once "CalaisPHP.php";
$phpif = new CalaisPHP("944599rdxsxdcrx27u8qkygj");
$phpif->setContentType("text/txt");



$xmlFileData = file_get_contents("http://sameerahuja.com/feed/");
$xmlFileData = str_replace('content:encoded','content',$xmlFileData);
$xmlData = new SimpleXMLElement($xmlFileData);
foreach($xmlData->channel->item as $item)
{
	echo "<a href='".$item->link."'>";
	echo $item->title."<br/></a>";
	echo $item->description."<br/><br/>";
	$content = $item->title. "<br/><br/>".$item->content;
	echo "<a href='viewtags.php?content=".$content."'>View Tags</a><br/><br/>";
}
?>
</body>
</html>