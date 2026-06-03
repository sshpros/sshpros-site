<?php
	if (!defined('ABSPATH')){ exit; }
	use Elementor\Icons_Manager;
	$classes = array();
   $classes[] = 'gsc-icon-box-group layout-list list-icon-two';

	$this->add_render_attribute('wrapper', 'class', $classes);

?>

<div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
	<div class="iconbox-list">
		<?php
			echo '<ul>';
				if($settings['title']){
					echo '<li class="title">' .esc_html__($settings['title']). '</li>';
				}
				foreach ($settings['icon_boxs'] as $item){ 
					$active = $item['active']=='yes' ? ' active' : '';
					$has_icon = ! empty( $item['selected_icon']['value']); 
					echo '<li class="icon-item' . $active . '">';
						if($has_icon){ 
							echo '<span class="icon">';
								Icons_Manager::render_icon($item['selected_icon'], [ 'aria-hidden' => 'true' ]); 
							echo '</span>';
						}
						if($item['title']){ 
							echo '<span class="name">' . $item['title'] . '</span>';
						}
				 		$this->gva_render_link_overlay( $item['link'], 'link-overlay');
					echo '</li>';	
				}
			echo '</ul>';	
		?>
	</div>   
</div>
