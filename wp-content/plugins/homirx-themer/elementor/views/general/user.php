<?php
   use Elementor\Icons_Manager;
   
   $this->add_render_attribute( 'block', 'class', ['gva-user', ' text-' . $settings['align'], $settings['style']] );
   $style = $settings['style'];
   $login_text = $settings['login_text'] ? $settings['login_text'] : "Sign in";
   $register_text = $settings['register_text'] ? $settings['register_text'] : "Register";
?>

<div <?php echo $this->get_render_attribute_string( 'block' ) ?>>
   <?php if(is_user_logged_in()){ ?>
      <?php
         $user_id = get_current_user_id();
         $user_info = wp_get_current_user();
         $_random = gaviasthemer_random_id();
         $args = [
            'echo'        => false,
            'menu'        => $settings['menu'],  
            'menu_class'  => 'gva-user-menu clearfix',
            'menu_id'     => 'menu-' . $_random,
            'container'   => 'div'
         ];
         if(class_exists('Homirx_Walker')){
            $args['walker' ]     = new Homirx_Walker();
         }
         $menu_html = '<div class="hi-account">' . $settings['hi_text'] . $user_info->display_name . '</div>';
         $menu_html .= wp_nav_menu($args);
      ?>
      <div class="login-account">
         <div class="profile">
            <div class="avata">
               <?php 
               	$avatar_html = '';
               	if(class_exists('ATBDP_Listing')){
               		$author = \Directorist\Directorist_Listing_Author::instance();
               		$avatar_html = $author->avatar_html();
               	}else{
	                  $user_avatar = get_avatar_url($user_id, array('size' => 90));
	                  $avatar = get_the_author_meta( '_user_avatar', $user_id);
	                  if($avatar){
	                    	$avatar = wp_get_attachment_image_src( $avatar, 'thumbnail' );
	                    	if( isset($avatar[0]) && $avatar[0] ){
	                        $user_avatar = $avatar[0];
	                    	}
	                  }
	                  $avatar_url = !empty($user_avatar) ? $user_avatar : (get_template_directory_uri() . '/images/placehoder-user.jpg');
               		$avatar_html = '<img src="' . esc_url($avatar_url) . '" alt="' . esc_html($user_info->display_name) . '">';
               	}
               	echo wp_kses_post($avatar_html);
               ?>
            </div>
	         <div class="username">
	         	<span class="user-text"><?php echo esc_html($user_info->display_name) ?></span>
	         	<i class="icon fas fa-angle-down"></i>
	         </div>
         </div>  
         
         <div class="user-account">
            <?php echo ($menu_html) ?>
         </div> 

      </div>

   <?php }else{ ?>
      <?php 
         
         // Login
      	$login_page_id 	= (int) get_directorist_option( 'signin_signup_page' );
			$login_link  		= $login_page_id ? get_page_link( $login_page_id ) : \ATBDP_Permalink::get_dashboard_page_link();
			$login_link 		= !empty($settings['login_link']) ? $settings['login_link'] : $login_link;

         // Register
         $register_link = site_url('/wp-login.php?action=register&redirect_to=' . get_permalink());
         if($login_link){
            $register_link = add_query_arg( array('active' => 'signup'),  $login_link );
         }
         $register_link = !empty($settings['register_link']) ? $settings['register_link'] : $register_link;
      ?>

      <?php if($style == 'style-1'){ ?>
	      <div class="login-account without-login">
	         <div class="profile">
	            <div class="avata avata-icon">
	               <?php if($settings['selected_icon']){ ?>
	                  <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'class' => 'icon', 'aria-hidden' => 'true' ] ); ?>
	               <?php } ?>
	            </div>
	         </div>
	         <div class="user-account">
	            <ul class="my_account_nav_list gva-user-menu">
	               <li>
	                  <a class="login-link" href="<?php echo esc_url($login_link) ?>">
	                     <i class="fa-regular fa-user"></i>
	                     <?php echo esc_html($login_text); ?>
	                  </a>
	               </li>
	               <li>
	                  <a class="register-link" href="<?php echo esc_url($register_link) ?>">
	                     <i class="fa-solid fa-user-plus"></i>
	                     <span class="register-text"><?php echo esc_html($register_text); ?></span>
	                  </a>
	               </li>
	            </ul>
	         </div>
	      </div>
	   <?php } ?>

	   <?php if($style == 'style-2'){ ?>
	      <div class="login-register">
	         <span class="box-icon">
	            <?php Icons_Manager::render_icon( $settings['selected_icon'], [ 'class' => 'icon', 'aria-hidden' => 'true' ] ); ?>
	         </span>
	         <span class="user-sign-in">
	            <a class="sign-in-link" href="<?php echo esc_url($login_link) ?>">
	               <span class="sign-in-text"><?php echo esc_html($login_text); ?></span>
	            </a>
	         </span>
	         <span class="text-or"><?php echo esc_html__('or', 'homirx-themer') ?></span> 
	         <span class="user-register">  
	           	<a class="register-link" href="<?php echo esc_url($register_link) ?>">
	              	<span class="register-text"><?php echo esc_html($register_text); ?></span>
	            </a>
	         </span>
	      </div>
	   <?php } ?>
         
   <?php } ?>
</div>