<?php
	if (!defined('ABSPATH')) {
		exit; 
	}
	global $homirx_post;
	if (!$homirx_post){
		return;
	}
	?>
	
	<div class="post-category">
		<?php 
			if($settings['show_icon']){ 
				echo '<i class="far fa-folder-open"></i>';
			}
			echo get_the_category_list( ", ", '', $homirx_post->ID ) . '</span>';
		?>
	</div>      

