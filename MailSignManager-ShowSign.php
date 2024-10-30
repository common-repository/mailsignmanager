<?php
/*
	Page Use: Show Sign
	Plugin URI:
	Description: Show the sign
	Version: 0.1
	Author: Sylvain Gendrot
	Author URI:
*/

//for debug
//$message= "\n\nMailSignManager debug => file: ".__FILE__." - line: 12";
//error_log(print_r($message, true), 3, "./errors.log");


// If the JSON file template signature exist, load it
if (file_exists ("./MailSignUpdater-MySignatures.json"))
{
	//Decode JSON and paste in Array
	$MailSignManagerPlugin_aJsonSign = json_decode(file_get_contents("./MailSignUpdater-MySignatures.json"), true);

	print_r($MailSignManagerPlugin_aJsonSign['Signature']);

}//end of if (file_exists ("./MailSignManager-MySignatures.json"))
else {
  print_r("Error - We can't find the signature");
}

?>
