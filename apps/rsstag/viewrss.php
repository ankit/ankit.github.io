<html>
<head>
<title>RSS Tags</title>
<link rel="StyleSheet" href="style.css" type="text/css">
</head>
<body>
<a href="http://opencalais.com/"><img src="images/calais_logo.gif"></a><br/><br/>
<?php
include "class_rdf_parser.php";
//include "rdfdump.php";
require_once "CalaisPHP.php";
$phpif = new CalaisPHP("944599rdxsxdcrx27u8qkygj");
$phpif->setContentType("text/html");

$xml_file = "tags.xml";
//Creating rdf file
//$rdf_file = "tags.rdf";

//for parsing the RDF File

/*$statements="";
$rdf = new Rdf_parser();
$rdf->rdf_parser_create(NULL);
$rdf->rdf_set_statement_handler("handle_rdf");
$rdf->rdf_set_base($rdf_file);
$rdf->rdf_set_user_data($statements);
*/

//defining the statement handler for rdf parsing

/*function handle_rdf(&$user_data,$subject_type,$subject,$predicate,$ordinal,$object_type,$object,$xml_langs)
{
//printf("ordinal($ordinal) triple(");
switch( $subject_type )
{
case RDF_SUBJECT_TYPE_URI:
printf( "\"%s\"", $subject );
break;
case RDF_SUBJECT_TYPE_DISTRIBUTED:
printf( "distributed(\"%s\")", $subject );
break;
case RDF_SUBJECT_TYPE_PREFIX:
printf( "prefix(\"%s\")", $subject );
break;
case RDF_SUBJECT_TYPE_ANONYMOUS:
printf( "anonymous(\"%s\")", $subject );
break;
}
printf( ", \"%s\", ", $predicate );
switch( $object_type )
{
case RDF_OBJECT_TYPE_RESOURCE:
printf( "\"%s\"", $object );
break;
case RDF_OBJECT_TYPE_LITERAL:
printf( "literal(\"%s\")", $object );
break; case RDF_OBJECT_TYPE_XML:
printf( "XML" );
break;
}
printf( ")<br/>\n" );

}
*/
$feedlink = (string)$_POST['feed'];
$xmlFileData = file_get_contents($feedlink);
$xmlFileData = str_replace('content:encoded','content',$xmlFileData);
$xmlData = new SimpleXMLElement($xmlFileData);
$no=0;
foreach($xmlData->channel->item as $item)
{
	
	echo "<a href='".$item->link."'>";
	echo $item->title."<br/></a>";
	echo $item->description."<br/><br/>";
	$content = $item->title. "<br/><br/>".$item->content;
	$response = $phpif->callEnlighten($content);
	$response = html_entity_decode($response);
	if($no==4)
	{
	$fh = fopen($xml_file,'w');
	fwrite($fh,$response);
	fclose($fh);
	}
	$xml = new SimpleXMLElement($response);
	echo "Tags: <br/>";
	$any_tags=false;
	foreach($xml->OpenCalaisSimple->CalaisSimpleOutputFormat->children() as $type)
	{
		if($type->getName()!=="URL")
		{
		$any_tags=true;
		echo "<a href='#' title='".$type->getName()."(".$type['count'].")'>".$type."</a>";
		echo ", ";
		}
		//echo $type->getName();
		else
		{
			
		}
		
	}
	if($any_tags==false)
		echo "Sorry! No tags found!";
/*	while(!$done)
	{
		$buf = fread( $fh, 512 );
		$done = feof($fh);
		if ( ! $rdf->rdf_parse( $buf, strlen($buf), feof($fh) ) )
		{
			die("An error was detected while parsing may be the document is not
			well-formed");
		}
	}
*/	
	$no++;
	echo "<br/><br/>";
	//echo "<a href='viewtags.php?content=".$content."'>View Tags</a><br/><br/>";

}
?>
</body>
</html>