<?php
/*
 * Created on Apr 15, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 * 
 * This php file returns the results of the OpenCalais Enlighten API
 * call in raw format with Content-Type text/xml
 */
header("Content-Type: text/xml");

require_once "CalaisPHPIf.php";

if (!isset($_POST['content']) || !isset($_POST['type']))
{
	echo "<Error>Invalid Request</Error>";
}

$phpif = new CalaisPHPIf("944599rdxsxdcrx27u8qkygj");
$phpif->setContentType($_POST['type']);
echo $phpif->callEnlighten($_POST['content']);
 
?>
