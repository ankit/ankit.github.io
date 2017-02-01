<?php
include_once("class_rdf_parser.php");

/* This is the URI of the document to be dumped: */

$base="http://www.w3.org/2000/10/rdf-tests/RSS_1.0/rss_5.3_1.rdf";
//$base="resource-01.rdf";

/* RDF Parser Handler functions are defined below this code */

$statements=0;

$input = fopen($base,"r");
$rdf=new Rdf_parser();
$rdf->rdf_parser_create( NULL );
$rdf->rdf_set_user_data( $statements );
$rdf->rdf_set_statement_handler( "my_statement_handler" );
$rdf->rdf_set_parse_type_literal_handler("my_start_parse_type_literal_handler","my_end_parse_type_literal_handler" );
$rdf->rdf_set_element_handler("my_start_element_handler", "my_end_element_handler" );
$rdf->rdf_set_character_data_handler("my_character_data_handler" );
$rdf->rdf_set_warning_handler("my_warning_handler" );
$rdf->rdf_set_base($base );
$done=false;
while(!$done)
{
  $buf = fread( $input, 512 );
  $done = feof($input);

  if ( ! $rdf->rdf_parse( $buf, strlen($buf), feof($input) ) )
  {
    printf(
	"**** ERROR **** : %s at line %s",
	print( xml_get_error_code( $rdf->rdf_get_xml_parser() ) ),
	print( xml_get_current_line_number($rdf->rdf_get_xml_parser() ) ) );

	return 1;
  }
} 
/* close file. */
fclose( $input );
$rdf->rdf_parser_free();
printf( "Total statements: ". $statements );


/* handlers */

function my_statement_handler(
	&$user_data,
	$subject_type,
	$subject,
	$predicate,
	$ordinal,
	$object_type,
	$object,
	$xml_lang )
{
	//$statements = $user_data;

	++$user_data;

	printf( "ordinal($ordinal) triple(" );

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
		break;
	case RDF_OBJECT_TYPE_XML:
		printf( "XML" );
		break;
	}

	printf( ")<br/>\n" );

}

	
	
function my_start_parse_type_literal_handler(
	$user_data )
{
	
	printf( "start parse type literal<br/>" );
}


function my_end_parse_type_literal_handler(
	$user_data )
{
	printf( "end parse type literal<br/>" );
}

function my_start_element_handler( 
	$user_data, 
	$name, 
	$attributes )
{
	printf( "start element: $name<br/>\n" );
}

function my_end_element_handler( 
	$user_data, 
	$name )
{
	
	printf( "end element: %s<br/>\n", $name );
}

function my_character_data_handler( 
	$user_data, 
	$s, 
	$len )
{
	
	printf( "characters: $s" );

	

	printf( "<br/>\n" );
}

function my_warning_handler(
	$warning )
{
	printf( "**** WARNING **** : %s<br/>", $warning );
}


?>