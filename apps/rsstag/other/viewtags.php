<?php
header("Content-Type: text/xml");

require_once "CalaisPHP.php";

$phpif = new CalaisPHP("944599rdxsxdcrx27u8qkygj");
$phpif->setContentType("text/txt");
/*echo $phpif->callEnlighten("For a couple of weeks now I've been monitoring what I do on my Mac using two tracker tools: Wakoopa and RescueTime. Both have unique approaches to the theme of tracking. Wakoopa builds a social network around the applications that you use. It lets you build 'teams' of people and see what your friends have [...]
Experiments with publishing application activity
For a couple of weeks now I've been monitoring what I do on my Mac using two tracker tools: Wakoopa and RescueTime. Both have unique approaches to the theme of tracking. Wakoopa builds a social network around the applications that you use. It lets you build 'teams' of people and see what your friends have been using. The other two significant things that it does are statistical visualizations, and recommendations of apps based on what you've been using. So if you've been using a lot of TextEdit lately, it might recommend TextMate as a 'similar' application.
This, according to my guesswork, they do by matching application tags."); 
*/
echo $phpif->callEnlighten($_GET['content']);

?>

