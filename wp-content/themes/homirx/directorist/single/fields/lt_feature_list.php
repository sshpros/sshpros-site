<?php

if ( ! defined( 'ABSPATH' ) ) exit;
$id = $listing->id;
$values = isset($data['value']) && $data['value'] ? $data['value'] : '';
$items = explode("\n", $values);
?>

<div class="property-single-info property-single-amenities">
	<ul class="amenities-list">
		<?php 
			foreach ($items as $key => $value) {
				if($value){
					echo '<li>' . esc_html($value) . '</li>';	
				}
			}
		?>
	</ul>
</div>