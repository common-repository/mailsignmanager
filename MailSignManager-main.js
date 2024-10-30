/*
Page Use: JS de la page du plugin MailSignManager
Plugin URI:
Description: Page JS du plugin MailSignManager
Version: 0.8
Author: Sylvain Gendrot
Author URI:
*/





/**
* When clic en Valid button
*/
function MailSignManagerPlugin_SaveAndPreviewMailSign() {

  jQuery(document).ready(
    function($) {

      var MailSignManagerPlugin_JS_data = {
        'action': 'MailSignManagerPlugin_JS_SaveAndPreview',
        'MailSignManagerPlugin_picture':$("#MailSignManagerPlugin_picture").val(),
        'MailSignManagerPlugin_username':$("#MailSignManagerPlugin_username").val(),
        'MailSignManagerPlugin_blogname':$("#MailSignManagerPlugin_blogname").val(),
        'MailSignManagerPlugin_contactdetail1':$("#MailSignManagerPlugin_contactdetail1").val(),
        'MailSignManagerPlugin_contactdetail2':$("#MailSignManagerPlugin_contactdetail2").val(),
        'MailSignManagerPlugin_contactdetail3':$("#MailSignManagerPlugin_contactdetail3").val(),
        'MailSignManagerPlugin_NetworkList':[]
      };


      $.each( $("#MailSignManagerPlugin_tabNetwork :text"), function( index, value ){
          MailSignManagerPlugin_JS_data['MailSignManagerPlugin_NetworkList'].push( { 'Id':value.id, 'URL':value.value} );
      });


      jQuery.post(ajaxurl, MailSignManagerPlugin_JS_data,
        function(response) {

          //Refresh the Preview div with new data
          $("#MailSignManagerPlugin_tDemoSign").html(response.Signature);//document.getElementById('MailSignManagerPlugin_tCodeSign').value);

        });//End of function(response)

      });//end of function($) in jQuery(document).ready

}//end of function MailSignManagerPlugin_SaveAndPreviewMailSign



/**
* Action when clic on img network Button.
*/
function MailSignManagerPlugin_NetworkRemove(MailSignManagerPlugin_JS__ID) {

  jQuery(document).ready(
    function($) {
      // remove the Row
      $("#MailSignManagerPlugin_tr"+MailSignManagerPlugin_JS__ID).remove();

    }); //end of function($) in jQuery(document).ready
  } // end of function MailSignManagerPlugin_NetworkRemove

/**
* Action when clic on Add nework Button.
*/
function MailSignManagerPlugin_NetworkAdd() {

  jQuery(document).ready(
    function($) {

      var MailSignManagerPlugin_JS_NetworkSelect = $("#MailSignManagerPlugin_NetworkSelect").find(":selected");
      // the content to add
      var MailSignManagerPlugin_JS_ContentCell = "<tr id=\"MailSignManagerPlugin_tr"+MailSignManagerPlugin_JS_NetworkSelect.val()+"\" ><th>"+MailSignManagerPlugin_JS_NetworkSelect.text()+"</th>";
      MailSignManagerPlugin_JS_ContentCell += "<td><input name=\""+MailSignManagerPlugin_JS_NetworkSelect.val()+"\" id=\""+MailSignManagerPlugin_JS_NetworkSelect.val()+"\" value=\"my profil\" class=\"regular-text\" type=\"text\">";
      MailSignManagerPlugin_JS_ContentCell += "<td><button class=\"MailSignManagerPlugin_NetworkButton\" id=\"MailSignManagerPlugin_"+MailSignManagerPlugin_JS_NetworkSelect.val()+"\" onClick=\"MailSignManagerPlugin_NetworkRemove('"+MailSignManagerPlugin_JS_NetworkSelect.val()+"')\"></button> </td></tr>";
      // insertCell
      $(MailSignManagerPlugin_JS_ContentCell).prependTo("#MailSignManagerPlugin_tabNetwork");

      // remove selected option
  //    $("#MailSignManagerPlugin_NetworkSelect").find(":selected").remove(); // too long to manage for the fisrt version

    }); //end of function($) in jQuery(document).ready

}// end of function MailSignManagerPlugin_NetworkAdd



/**
* code for "select an image"
*/
jQuery(document).ready(
  function($) {

    var MailSignManager_media_init = function()  {
      var clicked_button = false;

      jQuery('#MailSignManagerPlugin_picture').each(function (i, input) {
        $("#MailSignManagerPlugin_picButton").click(function (event) {
          event.preventDefault();

          var selected_img;
          clicked_button = jQuery(this);
          // check for media manager instance
          if(wp.media.frames.MailSignManager_frame) {
            wp.media.frames.MailSignManager_frame.open();
            return;
          }
          // configuration of the media manager new instance
          wp.media.frames.MailSignManager_frame = wp.media({
            title: 'Select image',
            multiple: false,
            library: {
              type: 'image'
            },
            button: {
              text: 'Use selected image'
            }
          });

          // Function used for the image selection and media manager closing
          var MailSignManager_media_set_image = function() {
            var selection = wp.media.frames.MailSignManager_frame.state().get('selection');

            // no selection
            if (!selection) {
              return;
            }

            // iterate through selected elements
            selection.each(function(attachment) {
              $('#MailSignManagerPlugin_picture').val(attachment.attributes.url);
            });
          };// end of var MailSignManager_media_set_image = function()

          // closing event for media manger
          wp.media.frames.MailSignManager_frame.on('close', MailSignManager_media_set_image);
          // image selection event
          wp.media.frames.MailSignManager_frame.on('select', MailSignManager_media_set_image);
          // showing media manager
          wp.media.frames.MailSignManager_frame.open();
        });// end of $("#MailSignManagerPlugin_picButton").click(function (event)
      });//end of   jQuery(selector).each(function (i, input)
    };// end of var MailSignManager_media_init = function()

    MailSignManager_media_init();

  });//en of jQuery(document).ready
