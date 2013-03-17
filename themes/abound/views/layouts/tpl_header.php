<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Nissen Idea</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free yii themes, free web application theme">
    <meta name="author" content="Webapplicationthemes.com">
	<link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php
	  $baseUrl = Yii::app()->theme->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  Yii::app()->clientScript->registerCoreScript('jquery');
	?>
    <!-- Fav and Touch and touch icons -->
    <link rel="shortcut icon" href="<?php echo $baseUrl;?>/img/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl;?>/img/icons/apple-touch-icon-57-precomposed.png">

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
    <!-- <script src="http://code.jquery.com/jquery-1.8.3.js"></script> -->
    <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<?php  
	  $cs->registerCssFile($baseUrl.'/css/bootstrap.min.css');
	  $cs->registerCssFile($baseUrl.'/css/bootstrap-responsive.min.css');
	  $cs->registerCssFile($baseUrl.'/css/abound.css');
      if("Lotofacil" == Yii::app()->params['engine']) {
        $cs->registerCssFile($baseUrl.'/css/style-red.css');
      } else {
        $cs->registerCssFile($baseUrl.'/css/style-blue.css');
      }
	  
	  $cs->registerCssFile($baseUrl.'/css/nissenidea.css');
	  
	  $cs->registerScriptFile($baseUrl.'/js/bootstrap.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.sparkline.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.flot.pie.min.js');
	  $cs->registerScriptFile($baseUrl.'/js/charts.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.knob.js');
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.masonry.min.js');
	?>
	
	
    <script>
    if(!window.log) {window.log = function() {log.history = log.history || [];log.history.push(arguments);if(this.console) {console.log(Array.prototype.slice.call(arguments));}};}

    $(function() {
    	$( "#dialog" ).dialog({ 
    		autoOpen: false,
            modal: true,
            width: 340,
            buttons: {
                Cancel: function() {
                    $( this ).dialog( "close" );
                },
                "Send Emails": function() {
                    $( this ).dialog( "close" );
                    //get emails
                    if(0<$('#sendEmails input[type="hidden"]').length){
						var emails = [];

	                    $('#sendEmails input[type="hidden"].emails').each(function() {	emails.push($(this).val());	});

	                    var params = {'id': $('#sendEmails #id').val(),'email':emails};
	                    $.ajax({
						  type: 'POST',
						  url: '<?php echo Yii::app()->params["root"]."index.php/combinationSet/email/"; ?>',
						  data: params, 
						  success: function(ret){

						  	log('success', ret);
						  },
						});
                    }

                    
                }
            }
    	});
        $( "#toEmail, #notToEmail" ).sortable({
            connectWith: ".connectedSortable"
        }).disableSelection();

        $( "#toEmail" ).on( "sortreceive", function( event, ui ) {
        	log('ui.item', $('sendEmails').find('input[value="'+ui.item.find('.email').text()+'"]').length, 'input[value="'+ui.item.find('.email').text()+'"]');

        	if(0 >= $('sendEmails').find('input[value="'+ui.item.find('.email').text()+'"]').length){
        		log('remove email');
        		log('ui.item.find(".email").text', ui.item.find('.email').text());
				//$('sendEmails').find(ui.item).remove();
				$('#sendEmails').prepend('<input type="hidden" class="emails" value="'+ui.item.find('.email').text()+'" />')
        	}
        	updateName();        	
        } );
        $( "#notToEmail" ).on( "sortreceive", function( event, ui ) {
        	if(0 >= $('#sendEmails').find(ui.item).length){
        		var search = 'input[value="'+ui.item.find('.email').text()+'"]';
        		var q = $('#sendEmails '+search);
				q.remove();
        	}
        	updateName();
        } );
    });
 	function updateName() {
 		log('update Name');
 		$('#sendEmails input[type="hidden"].emails').each(function() {
 			var index = $(this).index();
 			log("index:", index, "attr:", $(this).attr('name'));
 			$(this).attr('name', 'email['+index+']');
 		});
 	}
    </script>
	
  </head>
  <body>