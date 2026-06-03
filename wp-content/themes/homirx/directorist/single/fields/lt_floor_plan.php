<?php

if ( ! defined( 'ABSPATH' ) ) exit;
$id = $listing->id;
$values = isset($data['value']) && $data['value'] ? $data['value'] : false;
?>

<div class="property-single-info property-floor-plan">
	<div class="floor-plan-wrap">
		<ul class="nav nav-tabs" id="floor-plan-tab" role="tablist">
			<?php 
				$i = 0;
				foreach ($values as $key => $item) {
					$i++; 
					$class = $i == 1 ? 'active' : '';
					echo '<li class="nav-item" role="presentation">';
				    	echo '<button class="nav-link ' . esc_attr($class) . '" data-bs-toggle="tab" data-bs-target="#floor-plan-'. esc_html($key) . '" type="button" role="tab" aria-controls="home" aria-selected="true">';
				    		echo esc_html($item['title']);
				    	echo '</button>';
				  	echo '</li>';
				}
			?>
		</ul>
		<div class="tab-content">
			<?php 
				$i = 0;
				foreach ($values as $key => $item) {
					$i++; 
					$class = $i == 1 ? 'show active' : '';
					echo '<div class="tab-pane fade ' . esc_attr($class) . '" id="floor-plan-'. esc_html($key) . '" role="tabpanel">';
				    	echo '<div class="tab-item-content">';
				    		if(isset($item['image']) && $item['image']){
					    		echo '<div class="floor-plan-image">';
					    			echo '<a class="floor-plan-image-popup" href="' . esc_url($item['image']) . '" data-elementor-lightbox-slideshow="floor-plan-image-popup">';
					    				echo '<img src="' . esc_url($item['image']) . '" title="' . esc_html($item['title']) . '" />';
					    			echo '</a>';
					    		echo '</div>';
					    	}
					    	if(isset($item['desc']) && $item['desc']){
					    		echo '<div class="floor-plan-desc">';
				    				echo wpautop($item['desc']);
				    			echo '</div>';
					    	}
					   echo '</div>';
				  	echo '</div>';
				}
			?>
		</div>
	</div>
</div>