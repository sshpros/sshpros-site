<?php
	if (!defined('ABSPATH')){ exit; }
	use Elementor\Icons_Manager;

	$classes = array();
   $classes[] = 'gsc-icon-box-group layout-grid';

	$this->add_render_attribute('wrapper', 'class', $classes);

	//add_render_attribute grid
	$this->get_grid_settings();
?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<div <?php echo $this->get_render_attribute_string('grid') ?>>
		<?php
			$inumber = 1;
			foreach ($settings['icon_boxs'] as $item){ 
				$has_icon = ! empty( $item['selected_icon']['value']); 
				echo '<div class="item-columns">';
					include $this->get_template('general/icon-box-group/item.php');
				echo '</div>';
            $inumber++;
			} 
		?>
	</div>   
</div>
