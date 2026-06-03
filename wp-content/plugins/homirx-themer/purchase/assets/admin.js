
(function($) {
	"use strict";
	var gvaVerifyLicense = {
		init: function(){
			this.verityLicense();
			this.other();
		},

		verityLicense: function(){
			$("#gvaVerifyLicense").submit(function(e) {
			   e.preventDefault(); 
			   //$(this).find('.ajax-load').addClass('loading');
			   var form = $(this);
			   var actionUrl = 'https://gaviasthemes.com/tf/nndh_6689/';
			   var shopfront	= $('#verify_shopfront').val();
			   var purchase_code = $('#verify_purchase_code').val();
			   var buyer = $('#verify_buyer').val();
			   var website = $('#verify_website').val();
			   var theme_id = '56034370';
			   var data_verify = '';
			   var html = '';
			   $.ajax({
			      type: "POST",
			      url: actionUrl,
			    	//contentType : 'application/json; charset=utf-8',
			      data: {
			      	purchase_code: purchase_code,
			      	buyer: buyer,
			      	shopfront: shopfront,
			      	website: website,
			      	theme_id: theme_id
			      },
			      beforeSend: function(xhr){
			      	form.find('.ajax-load').addClass('loading');
			      },
			      success: function(data){
			      	if(data.error){
			      		html = '<div class="error">' + data.error + '</div>';
			      	}else{
			      		if(data.code == 'NOT_FOUND' || data.valid == false){
			      			html = '<div class="error">' + data.message + '</div>';
			      		}
			      		if(data.code == "VALID" || data.code == "ELEMENTS"){
			      			// Save to database
			      			data_verify = data;
			      			$.ajax({
									type: 'POST',
									dataType: 'json',
									url: form_ajax_object.ajaxurl,
									data: { 
										'action': 'gva_verify_license',
										'data_verify': data_verify, 
										'security': form_ajax_object.security_nonce
									},
									success: function(data_save){
									 	html = '<div class="notice notice-success">' + data_save.message + '</div>';
									 	$('#gvaVerifyResults').html(html);
									 	$('#gvaVerifyLicense').addClass('hidden_form');
									 	//console.log(data_save); 
									},
									error: function(xhr, resp, text) {
										console.log(xhr, resp, text);
					          	}
						  		});
			      		}
			      	}
			      	//console.log(html);
			        	$('#gvaVerifyResults').html(html);
			        // console.log(data); 
			      	form.find('.ajax-load').removeClass('loading');

			      },
		         error: function(xhr, resp, text) {
		            console.log(xhr, resp, text);
			      	form.find('.ajax-load').removeClass('loading');
		        }
			   });
			});
		},

		other: function(){
			$('#verifycodeagain').on('click', function(){
				if($('#gvaVerifyLicense').hasClass('hidden_form')){
					$('#gvaVerifyLicense').removeClass('hidden_form');
				}else{
					$('#gvaVerifyLicense').addClass('hidden_form');
				}
			});
		}
	}

	$(document).ready(function(){
	 	gvaVerifyLicense.init();
  	})

})(jQuery);

