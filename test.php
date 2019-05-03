<?php
namespace parser;

/*******************
* Author: Alex Skovrup
* Date: 03-05-2019
*******************/

/********
* Test if Parser works as intended
********/
/*************************
* This is a simple tester, just
* made for proof of concept.
*************************/

//Include parser
include ("Parser.php");

/****
* Prepare test data
****/
// Prepare object
$object = new \stdClass();
$object->htmlHeader = 'Invitation for the party!';
$object->companyName = 'Valve';
$object->user = 'Gabel';
$object->eventName = 'Half life 3 confirmed!';
$object->address = 'PO BOX 1688 Bellevue, WA 98009';

// Prepare array
$array = [
	'htmlHeader'=>'Invitation for the party!',
	'companyName'=>'Valve',
	'user'=>'Gabel',
	'eventName'=>'Half life 3 confirmed!',
	'address'=>'PO BOX 1688 Bellevue, WA 98009'
];

// Prepare html string
$htmlString = "
	<!DOCTYPE HTML>
	<html>
	<head></head>
	
	<body>
		<h1>:htmlHeader</h1>
		<p>On behalf of :companyName, we would like to invite :user to :eventName at :address<p>
		
		<p>Best regards, :companyName</p>
	</body>
	
	</html>
";

//For comparing results
$expectsHtml = "
	<!DOCTYPE HTML>
	<html>
	<head></head>
	
	<body>
		<h1>Invitation for the party!</h1>
		<p>On behalf of Valve, we would like to invite Gabel to Half life 3 confirmed! at PO BOX 1688 Bellevue, WA 98009<p>
		
		<p>Best regards, Valve</p>
	</body>
	
	</html>
";

//Prepare html file path
$htmlFilePath = "template.html";

//Set parser
$Parser = new TemplateParser();

//Prepare comparison
$expects = $Parser->validateHtml($expectsHtml);

/****
* Test parser works with array
****/
$result = $Parser->parseHtml($array, $htmlString);
if($result == $expects){
	print '<p>passed array test</p>';
}else{
	print '<p>Didn\'t pass array test</p>';
	print_r('<p><b>Expected</b>: <i>'.$expects.'</i></p>');
	print_r('<p><b>Received</b>: <i>'.$result.'</i></p>');
}
print '<hr/>';

/****
* Test parser works with object
****/
$result = $Parser->parseHtml($object, $htmlString);
if($result == $expects){
	print '<p>passed object test</p>';
}else{
	print '<p>Didn\'t pass object test</p>';
	print_r('<p><b>Expected</b>: <i>'.$expects.'</i></p>');
	print_r('<p><b>Received</b>: <i>'.$result.'</i></p>');
}
print '<hr/>';

/****
* Test parser works with html file
****/
$Parser->setHtmlFile(true);
$result = $Parser->parseHtml($object, $htmlFilePath);
if($result == $expects){
	print '<p>passed file test</p>';
}else{
	print '<p>Didn\'t pass file test</p>';
	print_r('<p><b>Expected</b>: <div>'.$expects.'</div></p>');
	print_r('<p><b>Received</b>: <div>'.$result.'</div></p>');
}
print '<hr/>';

/****
* Test html validation handling
****/
$result = $Parser->parseHtml($object, $htmlFilePath);
if($result == $expects){
	print '<p>passed html validation test</p>';
}else{
	print '<p>Didn\'t pass html validation test</p>';
	print_r('<p><b>Expected</b>: <i>'.$expects.'</i></p>');
	print_r('<p><b>Received</b>: <i>'.$result.'</i></p>');
}