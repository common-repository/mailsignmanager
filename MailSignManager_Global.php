<?php
/*
 Page Use: Fonction et variable globales
 Plugin URI:
 Description: Les fonctions de debug et globales
 Version: 0.81
 Author: Sylvain Gendrot
 Author URI:
 */

/**
 * Variables Globales
 **/

if (!defined('MailSignManager_PLUGIN_DIR'))
define('MailSignManager_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );



/**
 *
 * Exemple utilisation
 * MailSignManagerPlugin_log_me("popopo totototo",__FILE__, 15);
 * @param string $message => le message d'erreur à afficher
 * @param string $file => le fichier source de l'erreur
 * @param int $line => la ligne de l'erreur
 */
function MailSignManagerPlugin_log_me($MailSignManagerPlugin_message,$MailSignManagerPlugin_file,$MailSignManagerPlugin_line) {
	if (WP_DEBUG === true) {
		error_log("\n\n\nMailSignManager debug => file: ".$MailSignManagerPlugin_file." - line: ".$MailSignManagerPlugin_line, 3, MailSignManager_PLUGIN_DIR."errors.log");

		if (is_array($MailSignManagerPlugin_message) || is_object($MailSignManagerPlugin_message)) {
			error_log("\nMailSignManager debug =>", 3, MailSignManager_PLUGIN_DIR."errors.log");
			error_log(print_r($MailSignManagerPlugin_message, true), 3, MailSignManager_PLUGIN_DIR."errors.log");
		} else {
			error_log("\nMailSignManager debug => ".$MailSignManagerPlugin_message, 3, MailSignManager_PLUGIN_DIR."errors.log");
		}//fin else

//		error_log("MailSignManager debug => Fin"); // verif DEBUG ON
	}//fin if (WP_DEBUG === true)
}//fin function MailSignManagerPlugin_log_me($MailSignManagerPlugin_message,$MailSignManagerPlugin_file,$MailSignManagerPlugin_line)


/**
* Fonction écrivant le fichier MailSignManager-Infos.json
*
*
*/
function MailSignManagerPlugin_Write_InfoJS(){

  /**
	 * ecriture du fichier JSON
	 */
	//ouverture du fichier article
	$MailSignManagerPlugin_handle = fopen (MailSignManager_PLUGIN_DIR."MailSignManager-Infos.json" ,'w');

  //MailSignManagerPlugin_log_me($_REQUEST,__FILE__,59);

	// Content of the JSON File
	// line : opening hook
	$MailSignManagerPlugin_json = "{";
	// Line : Name of the Signature
	$MailSignManagerPlugin_json .= "\n\t\"MailSignName\": \"default\",";
	// line : Version Number
	$MailSignManagerPlugin_json .= "\n\t\"Version\": 0,";
	// line : Date of the version (format ISO 8601, ex: 2016-05-30T08:52:02+0000 )
	$MailSignManagerPlugin_json .= "\n\t\"Date\": ".json_encode(date(DATE_ISO8601,time())).",";
	// line : The infos
	// I must use preg_replace because JS has already started to format the input, but just " replace by \" . I must remove it to format for JSON
	$MailSignManagerPlugin_json .= "\n\t\"picture\": ".json_encode(preg_replace('/\\\"/','"',$_POST['MailSignManagerPlugin_picture'])).",";
	$MailSignManagerPlugin_json .= "\n\t\"username\": ".json_encode(preg_replace('/\\\"/','"',$_POST['MailSignManagerPlugin_username'])).",";
	$MailSignManagerPlugin_json .= "\n\t\"blogname\": ".json_encode(preg_replace('/\\\"/','"',$_POST['MailSignManagerPlugin_blogname'])).",";
	$MailSignManagerPlugin_json .= "\n\t\"contactdetail1\": ".json_encode(preg_replace('/\\\"/','"',$_POST['MailSignManagerPlugin_contactdetail1'])).",";
	$MailSignManagerPlugin_json .= "\n\t\"contactdetail2\": ".json_encode(preg_replace('/\\\"/','"',$_POST['MailSignManagerPlugin_contactdetail2'])).",";
	$MailSignManagerPlugin_json .= "\n\t\"contactdetail3\": ".json_encode(preg_replace('/\\\"/','"',$_POST['MailSignManagerPlugin_contactdetail3'])).",";
	$MailSignManagerPlugin_json .= "\n\t\"NetworkList\": ".json_encode($_POST['MailSignManagerPlugin_NetworkList']);

	// line : closing Hook
	$MailSignManagerPlugin_json .= "\n}";


	//enregistrement du fichier
	fwrite($MailSignManagerPlugin_handle,$MailSignManagerPlugin_json);
	fclose ($MailSignManagerPlugin_handle);

	// Call function to write JSON file for signature and send it to JS
	wp_send_json(mailSignUpdaterPlugin_Write_MySignJS($_POST));

}//fin de function MailSignManagerPlugin_Write_InfoJS()


/**
* Fonction écrivant le fichier JSON contenant la signature
*
*
*/
function mailSignUpdaterPlugin_Write_MySignJS($mailSignUpdaterPlugin_POST){

  /**
	 * ecriture du fichier JSON
	 */
	//ouverture du fichier article
	$mailSignUpdaterPlugin_handle = fopen (MailSignManager_PLUGIN_DIR."MailSignUpdater-MySignatures.json" ,'w');
	// Content of the JSON File
	// line 1: opening hook
	$mailSignUpdaterPlugin_json = "{";
	// Line 2: Name of the Signature
	$mailSignUpdaterPlugin_json .= "\n\t\"MailSignName\": \"default\",";
	// line 2: Version Number
	$mailSignUpdaterPlugin_json .= "\n\t\"Version\": 0,";
	// line 3: Date of the version (format ISO 8601, ex: 2016-05-30T08:52:02+0000 )
	$mailSignUpdaterPlugin_json .= "\n\t\"Date\": ".json_encode(date(DATE_ISO8601,time())).",";
	// line 4: The Signature
	// I must use preg_replace because JS has already started to format the input, but just " replace by \" . I must remove it to format for JSON

	$MailSignManagerPlugin_Sign = "";
	// If the JSON file template signature exist, load it
	if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Template.json"))
	{
		//Decode JSON and paste in Array
		$MailSignManagerPlugin_aJsonSign = json_decode(file_get_contents(MailSignManager_PLUGIN_DIR."MailSignManager-Template.json"), true);

		//replace hooks in sign by data
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*picture-url*__",$mailSignUpdaterPlugin_POST['MailSignManagerPlugin_picture'],$MailSignManagerPlugin_aJsonSign['Signature']);
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*username*__",$mailSignUpdaterPlugin_POST['MailSignManagerPlugin_username'],$MailSignManagerPlugin_aJsonSign['Signature']);
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*blog-url*__","",$MailSignManagerPlugin_aJsonSign['Signature']);
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*blogname*__",$mailSignUpdaterPlugin_POST['MailSignManagerPlugin_blogname'],$MailSignManagerPlugin_aJsonSign['Signature']);
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*contactdetail1*__",$mailSignUpdaterPlugin_POST['MailSignManagerPlugin_contactdetail1'],$MailSignManagerPlugin_aJsonSign['Signature']);
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*contactdetail2*__",$mailSignUpdaterPlugin_POST['MailSignManagerPlugin_contactdetail2'],$MailSignManagerPlugin_aJsonSign['Signature']);
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*contactdetail3*__",$mailSignUpdaterPlugin_POST['MailSignManagerPlugin_contactdetail3'],$MailSignManagerPlugin_aJsonSign['Signature']);


		$MailSignManagerPlugin_UserNetIcons= "";
		// If the JSON file NetworkList exist, load it
		if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Network.json"))
		{
			//Decode JSON and paste in Array
			$MailSignManagerPlugin_aJsonNetwork = json_decode(file_get_contents(MailSignManager_PLUGIN_DIR."MailSignManager-Network.json"), true);

			// if something in the user network list, construct row
			if (! empty($mailSignUpdaterPlugin_POST['MailSignManagerPlugin_NetworkList'])){
				foreach($mailSignUpdaterPlugin_POST['MailSignManagerPlugin_NetworkList'] as $MailSignManagerPlugin_OnOfMyNetwork)
				{
					//human readable
					//looking for the position in the NetworkList (from MailSignManager-Network.json") the position of the userNetwork (from MailSignManager-Infos.json)
					//all this shit to get the clean Name of the Network
					$MailSignManagerPlugin_key = array_search($MailSignManagerPlugin_OnOfMyNetwork['Id'], array_column($MailSignManagerPlugin_aJsonNetwork['List'], 'Id'));

					$MailSignManagerPlugin_UserNetIcons .= "\n\n\t\t\t\t<span id=\"".$MailSignManagerPlugin_aJsonNetwork['List'][$MailSignManagerPlugin_key]['Id']."\">\n\t\t\t\t\t";
					$MailSignManagerPlugin_UserNetIcons .= "<a href=\"".$MailSignManagerPlugin_OnOfMyNetwork['URL']."\">";
					$MailSignManagerPlugin_UserNetIcons .= "<img width=\"20px\" height=\"20px\" src=\"".plugins_url( "img/".$MailSignManagerPlugin_aJsonNetwork['List'][$MailSignManagerPlugin_key]['Icon'], __FILE__ )."\"></a>";
					$MailSignManagerPlugin_UserNetIcons .= "\n\t\t\t\t</span>";
				}
			}//end of if (! empty($MailSignManagerPlugin_myNetworkList))
		}//end of if (! empty($MailSignManagerPlugin_myNetworkList))

		// add networkList
		$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*networkList*__",$MailSignManagerPlugin_UserNetIcons,$MailSignManagerPlugin_aJsonSign['Signature']);

		$MailSignManagerPlugin_Sign .= $MailSignManagerPlugin_aJsonSign['Signature'];
	}//end of if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Template.json"))
	else { // no template sign
		$MailSignManagerPlugin_Sign .= "Fail to load MailSignManager-Template.json";
	}


	$mailSignUpdaterPlugin_json .= "\n\t\"Signature\": ".json_encode(preg_replace('/\\\"/','"',$MailSignManagerPlugin_Sign));
	//$mailSignUpdaterPlugin_json .= "\n\t\"Signature\": \"".preg_replace('/\n/','\n',$_POST['mailSignUpdaterPlugin_tCodeSign'])."\"";//, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

	// line 5: closing Hook
	$mailSignUpdaterPlugin_json .= "\n}";
	//enregistrement du fichier
	fwrite($mailSignUpdaterPlugin_handle,$mailSignUpdaterPlugin_json);
	fclose ($mailSignUpdaterPlugin_handle);

	//return the JSON sign
	return ($MailSignManagerPlugin_aJsonSign);
}//fin de function mailSignUpdaterPlugin_Write_MySignJS()


?>
