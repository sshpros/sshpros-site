<?php
	$homirx_options = homirx_get_options();
?>
<div class="canvas-mobile">
	<div class="canvas-menu gva-offcanvas hidden">
	  	<a class="dropdown-toggle" data-canvas=".mobile" href="#" aria-label="dropdown"><i class="fas fa-bars"></i></a>
	</div>
	<div class="gva-offcanvas-content mobile">
		<div class="top-canvas">
			<?php $logo = (isset($homirx_options['header_logo']['url']) && $homirx_options['header_logo']['url']) ? $homirx_options['header_logo']['url'] : get_template_directory_uri().'/assets/images/logo.png' ; ?>
		  	<a class="logo-mm" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			 	<img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo( 'name' ); ?>" />
		  	</a>
			<a class="control-close-mm" href="#"><i class="far fa-times-circle"></i></a>
		</div>
		<div class="wp-sidebar sidebar">
			<?php do_action('homirx_mobile_menu'); ?>
			<div class="after-offcanvas">
				<?php
					if(is_active_sidebar('offcanvas_sidebar_mobile')){ 
						dynamic_sidebar('offcanvas_sidebar_mobile');
					}
				?>
			</div>    
	  </div>
	</div>
</div>