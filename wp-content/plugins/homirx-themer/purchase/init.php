<?php

class GVA_Verify_License {
   function __construct(){
      add_action( 'init', array($this, 'ajax_auth_init') );
		add_action('admin_menu', array($this, 'add_admin_menu'));
		add_action( 'admin_notices', array($this, 'verify_admin_notice') );
	}

	public function ajax_auth_init(){ 
      add_action( 'wp_ajax_gva_verify_license', array($this, 'verify') );
   }

	public function add_admin_menu(){
		add_menu_page(
			esc_html__('Verify License', 'homirx-themer'),
			esc_html__('Verify License', 'homirx-themer'),
			'manage_options',
			'gavias_verify_license',
			array($this, 'show_options'),
			'',
			3
		);
	}

	public function show_options(){
      wp_register_script('admin-verify-license', GAVIAS_HOMIRX_PLUGIN_URL . 'purchase/assets/admin.js', array('jquery') ); 
      wp_enqueue_style('admin-verify-license', GAVIAS_HOMIRX_PLUGIN_URL . 'purchase/assets/admin.css'); 
		wp_enqueue_script('admin-verify-license');

		wp_localize_script( 'admin-verify-license', 'form_ajax_object', array( 
		  'ajaxurl' => admin_url( 'admin-ajax.php' ),
		  'security_nonce' => wp_create_nonce( "gva_ajax_security_nonce" )
		));

		$data_verify = get_option('gav_license_verify');
		$purchase_code = isset($data_verify['data']['purchase_code']) ? $data_verify['data']['purchase_code'] : '';
		$show_form = true;
		$class_form = 'show_form';
		echo '<div class="gvaVerifyWrap">';
			if(isset($data_verify['code']) && $data_verify['code'] == 'VALID'){
				if($purchase_code){
					echo '<div class="notice notice-success notice-message">';
						echo 'The Purchase Code / License ' . $purchase_code.  ' is <b>VALID</b>';
					echo '</div>';
				}
			}

			echo '<div id="gvaVerifyMessage">';
				if(isset($data_verify['code']) && ($data_verify['code'] == 'VALID' || $data_verify['code'] == 'ELEMENTS')){
					$show_form = false;
					$class_form = 'hidden_form';
					echo esc_html__("Thank you for choosing our theme!", 'homirx-themer');
					echo '<div style="margin-top: 30px;"><a id="verifycodeagain" class="e-button e-button e-button--cta" href="#">Verify Purchase Code / License Again</a></div>';
				}
			echo '</div>';

			echo '<div id="gvaVerifyResults"></div>';
			
			echo '<form id="gvaVerifyLicense" class="gvaVerifyLicense ' . $class_form . '" method="POST">';
				echo '<div class="ajax-load"></div>';
				echo '<div class="input-group">';
					echo '<label>' . esc_html__('Shopfront', 'homirx-themer') . '</label>';
					echo '<select name="shopfront" id="verify_shopfront">';
						echo '<option value="market">Envato Market (Themeforest)</option>';
						echo '<option value="elements">Envato Elements</option>';
					echo '</select>';
				echo '</div>';

				echo '<div class="input-group">';
					echo '<label>' . esc_html__('Purchase Code / License', 'homirx-themer') . '</label>';
					echo '<input name="purchase_code" id="verify_purchase_code">';
				echo '</div>';

				echo '<div class="input-group">';
					echo '<label>' . esc_html__('Envato Username', 'homirx-themer') . '</label>';
					echo '<input name="buyer" id="verify_buyer">';
				echo '</div>';

				echo '<div class="input-group">';
					echo '<label>' . esc_html__('Website', 'homirx-themer') . '</label>';
					echo '<input name="website" id="verify_website" value="'.get_option('siteurl', '').'" readonly="true">';
				echo '</div>';

				echo '<div class="input-group">';
					echo '<button class="e-button e-button e-button--cta" name="verify" type="submit">' . esc_html__('Verify Purchase Code / License', 'homirx-themer') . '</button>';
				echo '</div>';

				echo '<div class="notice notice-success notice-message">';
					echo trim('If you can\'t verify your purchase code, please <a href="https://themeforest.net/user/gavias">Contact Us Here</a>, We can support you!' , 'homirx-themer');
				echo '</div>';

			echo '</form>';
			
		echo '</div>';
	}

	public function verify(){
      check_ajax_referer('gva_ajax_security_nonce', 'security');
     
      if ( !is_user_logged_in() || !current_user_can('manage_options')){
         return;
      }
      $data_verify = isset($_POST['data_verify']) && $_POST['data_verify'] ? $_POST['data_verify'] : ''; 
      update_option('gav_license_verify', $data_verify);

      $message = trim( 'Purchase Code ' . esc_html($data_verify['data']['purchase_code']) . ' is Valid.<br><b> Thank you so much for purchased!</b>', 'homirx-themer');
      if(isset($data_verify['code']) && $data_verify['code'] == 'ELEMENTS'){
      	$message = esc_html__( "Thank you so much for download the theme from Envato Elements!", 'homirx-themer');
      }
      echo json_encode(
         array(
            'status'  => 'success',
            'message' => $message
         )
      );
      die();
   }

   function verify_admin_notice() {
   	$data_verify = get_option('gav_license_verify');
   	$purchase_code = isset($data_verify['data']['purchase_code']) ? $data_verify['data']['purchase_code'] : '';
   	if(empty($purchase_code)){
		   echo '<div class="notice e-notice e-notice--extended">';
		   	echo '<div class="e-notice__content">';
			   	echo'<h3><span style="color: red;">Important!</span> Verify purchase code or license for this website.</h3>';
			   	echo '<p><a class="e-button e-button e-button--cta" href="'.admin_url('admin.php?page=gavias_verify_license').'">Verify Theme</a></p>';
			   echo '</div>';
		   echo '</div>'; 
		}
	}
	
}

new GVA_Verify_License();