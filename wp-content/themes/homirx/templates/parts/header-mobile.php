<?php 
	$homirx_options = homirx_get_options();
?>

<div class="header-mobile header_mobile_screen">
  	<div class="header-mobile-content">
		<div class="header-content-inner clearfix"> 
		 
		  	<div class="header-left">
				<div class="logo-mobile">
					<?php $logo = (isset($homirx_options['header_logo']['url']) && $homirx_options['header_logo']['url']) ? $homirx_options['header_logo']['url'] : get_template_directory_uri().'/assets/images/logo.png' ; ?>
				  	<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					 	<img src="<?php echo esc_url($logo); ?>" alt="<?php bloginfo( 'name' ); ?>" />
				  	</a>
				</div>
		  	</div>

		  	<div class="header-right">
				<?php get_template_part('templates/parts/canvas-mobile'); ?>
		  	</div>
		</div>  
  	</div>
</div>