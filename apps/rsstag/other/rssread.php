<?php
header("Content-Type: text/xml");
require_once "rsstag.php";
$newCalais = new CalaisPHP();
$insideitem = false;
$tag="";
$title="";
$description="";
$link="";
function startElement($parser,$tagname,$attrs)
{
	global $insideitem,$tag;
	if($insideitem)
	{
		$tag=$tagname;
	}
	else if($tagname=="ITEM")
	{
		$insideitem = true;
	}
}

function characterData($parser,$data)
{
	global $insideitem, $tag,$title,$description,$link;
	if($insideitem)
	{
		switch($tag)
		{
			case "TITLE":
			$title.=$data;
			break;
		
			case "LINK":
			$link.=$data;
			break;
		
			case "DESCRIPTION":
			$description .=$data;
			break;
		}
	}
}
$no=0;
function endElement($parser,$tagname)
{
	global $insideitem, $tag, $title, $description, $link,$no,$newCalais;
	if($tagname=="ITEM")
	{
		/*$titles[] = trim($title);
		$links[] = trim($link);
		/*echo "<a href='".trim($link)."'>";
		echo "<br/><br/>".trim($title)."</a>";
		echo "<br/>".trim($description);
		echo "<br/>";*/
		$descriptions .= trim($description);
		if($no==0)
		{
			echo $newCalais->callCalais("A few days back, I stumbled onto this TEDTalk by Lawrence Lessig. It’s by far the most convincing description that I’ve come across of the state that our culture and law finds itself in today. Watch it and decide if you’d like to vote for drafting him into the Congress.");
		}
		
		$title="";
		$description="";
		$link="";
		$no++;
		$insideitem=false;
		
	}
}
/*for($i=0;$i<$no;$i++)
{
	echo "<a href='".$links[$i]."'>";
	echo "<br/><br/>".$titles[$i]."</a>";
	echo "<br/>".$descriptions[$i];
}
echo "I am a fool";*/

//for Parsing XML
$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser,"startElement","endElement");
xml_set_character_data_handler($xml_parser,"characterData");
$fp = fopen("http://www.sameerahuja.com/feed/","r") or die("Error reading RSS data!");

//Reading XML File
while($data = fread($fp,4096))
{
	xml_parse($xml_parser,$data,feof($fp));
}
fclose($fp);
xml_parser_free($xml_parser);
?>


