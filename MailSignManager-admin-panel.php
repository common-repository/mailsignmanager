<?php
/*
	Page Use: Administration page
	Plugin URI:
	Description: Administration page
	Version: 0.8
	Author: Sylvain Gendrot
	Author URI:
*/

/**
* Les déclaration des variables d'interface
*/
$MailSignManagerPlugin_TitlePage = "MailSignManager";
$MailSignManagerPlugin_DescDemoSign = "Demonstration of the signature";
$MailSignManagerPlugin_DescFormSign = "Elements of the signature";
$MailSignManagerPlugin_Valid = "Valid & Preview";

$MailSignManagerPlugin_DescPhoto = "Profile Picture";
$MailSignManagerPlugin_Photo = "";
$MailSignManagerPlugin_PhotoButton = "Select an image";
$MailSignManagerPlugin_DescName = "Your Name";
$MailSignManagerPlugin_Name = "My Name";
$MailSignManagerPlugin_DescBlogName = "Title";
$MailSignManagerPlugin_BlogName = "SubTitle";
$MailSignManagerPlugin_DescContactDetail1 = "Contact Detail 1";
$MailSignManagerPlugin_ContactDetail1 = "333-55551";
$MailSignManagerPlugin_DescContactDetail2 = "Contact Detail 2";
$MailSignManagerPlugin_ContactDetail2 = "johndoe@mymail.com";
$MailSignManagerPlugin_DescContactDetail3 = "Contact Detail 3";
$MailSignManagerPlugin_ContactDetail3 = "Skype ID: JohnDoe";
$MailSignManagerPlugin_myNetworkList = null;
$MailSignManagerPlugin_OpenSignButton = "Open in another Window";

$MailSignManagerPlugin_NetworkButton = "Add";


// If the JSON file w/ Preconfig signature exist, load it
if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Infos.json"))
{
	//Decode JSON and paste in Array
	$MailSignManagerPlugin_aJsonInfos = json_decode(file_get_contents(MailSignManager_PLUGIN_DIR."MailSignManager-Infos.json"), true);

	// overide default value
	$MailSignManagerPlugin_Photo = $MailSignManagerPlugin_aJsonInfos['picture'];
	$MailSignManagerPlugin_Name = $MailSignManagerPlugin_aJsonInfos['username'];
	$MailSignManagerPlugin_BlogName = $MailSignManagerPlugin_aJsonInfos['blogname'];
	$MailSignManagerPlugin_ContactDetail1 = $MailSignManagerPlugin_aJsonInfos['contactdetail1'];
	$MailSignManagerPlugin_ContactDetail2 = $MailSignManagerPlugin_aJsonInfos['contactdetail2'];
	$MailSignManagerPlugin_ContactDetail3 = $MailSignManagerPlugin_aJsonInfos['contactdetail3'];
	$MailSignManagerPlugin_myNetworkList = $MailSignManagerPlugin_aJsonInfos['NetworkList'];

}//end of if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Infos.json"))





//ligne 1: tete de page
$MailSignManagerPlugin_sLigne1 = "\n\n<div id =\"MailSignManagerPlugin\">\n\n\n\t\t<!-- ************ Debut du code pour le plugin MailSignManager ************ -->\n\n<div class=\"hildricon\"><br /></div><h1>".$MailSignManagerPlugin_TitlePage."</h1>\n<br />";

//Ligne 2: Le champs pour voir la démo de la signature
$MailSignManagerPlugin_sLigne2 = "\n<div id=\"MailSignManagerPlugin_l2\"><table class=\"form-table\"><tbody>";
$MailSignManagerPlugin_sLigne2 .= "\n\t<tr><th scope=\"row\"><h2>".$MailSignManagerPlugin_DescDemoSign.":</h2><br /></th><th></th>";
$MailSignManagerPlugin_sLigne2 .= "<tr><td class=\"MailSignManagerPlugin_tDemoSign\" id=\"MailSignManagerPlugin_tDemoSign\" >";


// If the JSON file template signature exist, load it
if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Template.json"))
{
	//Decode JSON and paste in Array
	$MailSignManagerPlugin_aJsonSign = json_decode(file_get_contents(MailSignManager_PLUGIN_DIR."MailSignManager-Template.json"), true);

	//replace hooks in sign by data
	$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*picture-url*__",$MailSignManagerPlugin_Photo,$MailSignManagerPlugin_aJsonSign['Signature']);
	$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*username*__",$MailSignManagerPlugin_Name,$MailSignManagerPlugin_aJsonSign['Signature']);
	$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*blog-url*__","",$MailSignManagerPlugin_aJsonSign['Signature']);
	$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*blogname*__",$MailSignManagerPlugin_BlogName,$MailSignManagerPlugin_aJsonSign['Signature']);
	$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*contactdetail1*__",$MailSignManagerPlugin_ContactDetail1,$MailSignManagerPlugin_aJsonSign['Signature']);
	$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*contactdetail2*__",$MailSignManagerPlugin_ContactDetail2,$MailSignManagerPlugin_aJsonSign['Signature']);
	$MailSignManagerPlugin_aJsonSign['Signature'] = str_replace ("__*contactdetail3*__",$MailSignManagerPlugin_ContactDetail3,$MailSignManagerPlugin_aJsonSign['Signature']);


	$MailSignManagerPlugin_UserNetIcons= "";
	// If the JSON file NetworkList exist, load it
	if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Network.json"))
	{
		//Decode JSON and paste in Array
		$MailSignManagerPlugin_aJsonNetwork = json_decode(file_get_contents(MailSignManager_PLUGIN_DIR."MailSignManager-Network.json"), true);

		// if something in the user network list, construct row
		if (! empty($MailSignManagerPlugin_myNetworkList)){
			foreach($MailSignManagerPlugin_myNetworkList as $MailSignManagerPlugin_OnOfMyNetwork)
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

	$MailSignManagerPlugin_sLigne2 .= $MailSignManagerPlugin_aJsonSign['Signature'];
}//end of if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Template.json"))
else { // no template sign
	$MailSignManagerPlugin_sLigne2 .= "Fail to load MailSignManager-Template.json";
}

$MailSignManagerPlugin_sLigne2 .= "</td>";
$MailSignManagerPlugin_sLigne2 .= "<td>";
$MailSignManagerPlugin_sLigne2 .= "\n<pre class=\"submit\"><input type=\"button\" class=\MailSignManagerPlugin_OpenSign\" value=\"".$MailSignManagerPlugin_OpenSignButton."\" onclick=\"window.open('".plugins_url('MailSignManager-ShowSign.php',__FILE__)."')\"/></pre></br >";
$MailSignManagerPlugin_sLigne2 .= "</td>";

$MailSignManagerPlugin_sLigne2 .= "\n</tbody></table></div><br />";
//Ligne 3: Debut tableau param
$MailSignManagerPlugin_sLigne3 = "\n<div id=\"MailSignManagerPlugin_l3\"><h2>".$MailSignManagerPlugin_DescFormSign.":</h2></div>";

//Ligne 4: Beginning of table
$MailSignManagerPlugin_sLigne4 = "\n<div id=\"MailSignManagerPlugin_l4\"><table class=\"form-table\"><tbody>";

//Ligne 5: Photo
$MailSignManagerPlugin_sLigne5 = "\n\t<tr><th scope=\"row\"><label for=\"MailSignManagerPlugin_name\">".$MailSignManagerPlugin_DescPhoto."</label></th>";
$MailSignManagerPlugin_sLigne5 .= "<td><input type=\"text\" name=\"MailSignManagerPlugin_picture\" id=\"MailSignManagerPlugin_picture\" value=\"".$MailSignManagerPlugin_Photo."\" class=\"regular-text\"><button id=\"MailSignManagerPlugin_picButton\" >".$MailSignManagerPlugin_PhotoButton."</button></td>";
$MailSignManagerPlugin_sLigne5 .= "</tr>";



//Ligne 6: Name
$MailSignManagerPlugin_sLigne6 = "\n\t<tr><th scope=\"row\"><label for=\"MailSignManagerPlugin_name\">".$MailSignManagerPlugin_DescName."</label></th>";
$MailSignManagerPlugin_sLigne6 .= "<td><input name=\"MailSignManagerPlugin_username\" id=\"MailSignManagerPlugin_username\" value=\"".$MailSignManagerPlugin_Name."\" class=\"regular-text\" type=\"text\"></td>";
$MailSignManagerPlugin_sLigne6 .= "</tr>";
//Ligne 7: Blog Name
$MailSignManagerPlugin_sLigne7 = "\n\t<tr><th scope=\"row\"><label for=\"MailSignManagerPlugin_blogname\">".$MailSignManagerPlugin_DescBlogName."</label></th>";
$MailSignManagerPlugin_sLigne7 .= "<td><input name=\"MailSignManagerPlugin_blogname\" id=\"MailSignManagerPlugin_blogname\" value=\"".$MailSignManagerPlugin_BlogName."\" class=\"regular-text\" type=\"text\"></td>";
$MailSignManagerPlugin_sLigne7 .= "</tr>";
//Ligne 8: contact detail 1
$MailSignManagerPlugin_sLigne8 = "\n\t<tr><th scope=\"row\"><label for=\"MailSignManagerPlugin_contactdetail1\">".$MailSignManagerPlugin_DescContactDetail1."</label></th>";
$MailSignManagerPlugin_sLigne8 .= "<td><input name=\"MailSignManagerPlugin_contactdetail1\" id=\"MailSignManagerPlugin_contactdetail1\" value=\"".$MailSignManagerPlugin_ContactDetail1."\" class=\"regular-text\" type=\"text\"></td>";
$MailSignManagerPlugin_sLigne8 .= "</tr>";
//Ligne 9: contact detail 2
$MailSignManagerPlugin_sLigne9 = "\n\t<tr><th scope=\"row\"><label for=\"MailSignManagerPlugin_contactdetail2\">".$MailSignManagerPlugin_DescContactDetail2."</label></th>";
$MailSignManagerPlugin_sLigne9 .= "<td><input name=\"MailSignManagerPlugin_contactdetail2\" id=\"MailSignManagerPlugin_contactdetail2\" value=\"".$MailSignManagerPlugin_ContactDetail2."\" class=\"regular-text\" type=\"text\"></td>";
$MailSignManagerPlugin_sLigne9 .= "</tr>";
//Ligne 10: contact detail 3
$MailSignManagerPlugin_sLigne10 = "\n\t<tr><th scope=\"row\"><label for=\"MailSignManagerPlugin_contactdetail3\">".$MailSignManagerPlugin_DescContactDetail3."</label></th>";
$MailSignManagerPlugin_sLigne10 .= "<td><input name=\"MailSignManagerPlugin_contactdetail3\" id=\"MailSignManagerPlugin_contactdetail3\" value=\"".$MailSignManagerPlugin_ContactDetail3."\" class=\"regular-text\" type=\"text\"></td>";
$MailSignManagerPlugin_sLigne10 .= "</tr>";
//Ligne 11: End of table
$MailSignManagerPlugin_sLigne11 = "\n</tbody></table></div><br />";


//Ligne 20: Beginning of table
$MailSignManagerPlugin_sLigne20 = "\n<div id=\"MailSignManagerPlugin_l20\"><table id=\"MailSignManagerPlugin_tabNetwork\" class=\"form-table\"><tbody>";



//Ligne 21: Add Network
$MailSignManagerPlugin_sLigne21 = "\n\t<tr>";


// If the JSON file NetworkList exist, load it
if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Network.json"))
{
	//Decode JSON and paste in Array
	$MailSignManagerPlugin_aJsonNetwork = json_decode(file_get_contents(MailSignManager_PLUGIN_DIR."MailSignManager-Network.json"), true);

	// if something in the user network list, construct row
	if (! empty($MailSignManagerPlugin_myNetworkList)){
		foreach($MailSignManagerPlugin_myNetworkList as $MailSignManagerPlugin_OnOfMyNetwork)
		{
			//human readable
			//looking for the position in the NetworkList (from MailSignManager-Network.json") the position of the userNetwork (from MailSignManager-Infos.json)
			//all this shit to get the clean Name of the Network
			$MailSignManagerPlugin_key = array_search($MailSignManagerPlugin_OnOfMyNetwork['Id'], array_column($MailSignManagerPlugin_aJsonNetwork['List'], 'Id'));

			$MailSignManagerPlugin_sLigne21 .= "\n\t<tr id=\"MailSignManagerPlugin_tr".$MailSignManagerPlugin_OnOfMyNetwork['Id']."\" >\n\t<th scope=\"row\">".$MailSignManagerPlugin_aJsonNetwork['List'][$MailSignManagerPlugin_key]['Name']."</th>";
			$MailSignManagerPlugin_sLigne21 .= "\n\t<td><input name=\"".$MailSignManagerPlugin_OnOfMyNetwork['Id']."\" id=\"".$MailSignManagerPlugin_OnOfMyNetwork['Id']."\" value=\"".$MailSignManagerPlugin_OnOfMyNetwork['URL']."\" class=\"regular-text\" type=\"text\">";
			$MailSignManagerPlugin_sLigne21 .= "\n\t<td><button class=\"MailSignManagerPlugin_NetworkButton\" id=\"MailSignManagerPlugin_".$MailSignManagerPlugin_OnOfMyNetwork['Id']."\" onClick=\"MailSignManagerPlugin_NetworkRemove('".$MailSignManagerPlugin_OnOfMyNetwork['Id']."')\"></button> </td></tr>";
		}
		$MailSignManagerPlugin_sLigne21 .= "\n\t<tr>";
	}//end of if (! empty($MailSignManagerPlugin_myNetworkList))


	//construct select
	$MailSignManagerPlugin_sLigne21 .= "\n\t<th scope=\"row\"><label for=\"MailSignManagerPlugin_NetworkSelect\"><select name=\"MailSignManagerPlugin_NetworkSelect\" id=\"MailSignManagerPlugin_NetworkSelect\">";

	sort($MailSignManagerPlugin_aJsonNetwork['List']);
	foreach($MailSignManagerPlugin_aJsonNetwork['List'] as $MailSignManagerPlugin_NetworkList)
	{
		$MailSignManagerPlugin_sLigne21 .= "\n\t\t<option value=\"".$MailSignManagerPlugin_NetworkList['Id']."\">".$MailSignManagerPlugin_NetworkList['Name']."</option>";
	}
	$MailSignManagerPlugin_sLigne21 .= "\n\t</select></label></th>";

	$MailSignManagerPlugin_sLigne21 .= "\n\t<td><input type=\"button\" value=\"".$MailSignManagerPlugin_NetworkButton."\" onclick=\"MailSignManagerPlugin_NetworkAdd()\"/></td><td></td>";
}//en of if (file_exists (MailSignManager_PLUGIN_DIR."MailSignManager-Network.json"))
else { // no old config, default
	$MailSignManagerPlugin_sLigne21 .= "<th scope=\"row\">Fail to load Network JSON File</th><td></td><td></td>";
}
$MailSignManagerPlugin_sLigne21 .= "</tr>";


//Ligne xx: End of table
$MailSignManagerPlugin_sLigne50 = "</tbody></table></div><br />";


//ligne: bouton valid
$MailSignManagerPlugin_sLigneValid = "\n<div id=\"MailSignManagerPlugin_l3\"><pre class=\"submit\"><input type=\"button\" class=\MailSignManagerPlugin_button\" value=\"".$MailSignManagerPlugin_Valid."\" onclick=\"MailSignManagerPlugin_SaveAndPreviewMailSign()\"/></pre></div></br >";

//Ligne: footer
$MailSignManagerPlugin_sLigneEnd = "\n\n\t\t<!-- ************ Fin du code pour le plugin MailSignManager ************ -->\n\n</div>\n\n";



//output
print_r( $MailSignManagerPlugin_sLigne1
.$MailSignManagerPlugin_sLigne2
.$MailSignManagerPlugin_sLigne3
.$MailSignManagerPlugin_sLigne4
.$MailSignManagerPlugin_sLigne5
.$MailSignManagerPlugin_sLigne6
.$MailSignManagerPlugin_sLigne7
.$MailSignManagerPlugin_sLigne8
.$MailSignManagerPlugin_sLigne9
.$MailSignManagerPlugin_sLigne10
.$MailSignManagerPlugin_sLigne11
.$MailSignManagerPlugin_sLigne20
.$MailSignManagerPlugin_sLigne21
.$MailSignManagerPlugin_sLigne50
.$MailSignManagerPlugin_sLigneValid
.$MailSignManagerPlugin_sLigneEnd
);

?>
