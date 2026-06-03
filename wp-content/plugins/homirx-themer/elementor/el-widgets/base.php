<?php
if(!defined('ABSPATH')){
	exit; // Exit if accessed directly.
}

use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

abstract class GVAElement_Base extends Elementor\Widget_Base {
  
   public function get_icon() {
      return 'homirx-icon-theme';
   }

   private function get_preview_post_default($post_type){
      $query = new WP_Query([
         'post_type'          => $post_type,
         'posts_per_page'     => 1,
         'numberposts'        => 1,
         'post_status'        => 'publish',
         'orderby'            => 'ID',
         'order'              => 'desc'
      ]);
      $post_id = 0;
       foreach ($query->posts as $post) {
         if($post->ID > 0){
            $post_id = $post->ID;
         }
      }
      wp_reset_postdata();
      return $post_id;
   }

   protected function render(){
      global $homirx_post, $post, $homirx_term_id, $homirx_job_preview;
      $post_type = get_post_type();
      $post_id = get_the_ID();

      if ($post_type === 'gva__template' || $post_type === 'elementor_library'){
      	$document = Plugin::instance()->documents->get($post_id);
      	$template_type = get_post_meta(get_the_ID(), 'gva_template_type', true);

      	$preview_post_id = 0;
      	$homirx_term_id = 0;
      	$post_preview = $document->get_settings('homirx_post_preview');

      	switch ($template_type){
      		case 'post_single_layout':
      			$preview_post_id = $post_preview ? $post_preview : $this->get_preview_post_default('post');
      			break;
      		case 'listing_single_layout':
      				$preview_post_id = $post_preview ? $post_preview : $this->get_preview_post_default('job_listing');
      			break;
      		case 'single_product_layout':	
      			$preview_post_id = $post_preview ? $post_preview : $this->get_preview_post_default('product');
      			break;
      		case 'archive_product_layout':

      		$terms = get_terms(array(
      			'taxonomy'	 => 'product_cat',
      			'hide_empty' => false,
      			'parent'   	 => 0,
      			'number'		 => 1,
      			'orderby'	 => 'term_id',
      			'order'		 => 'ASC'
      		));
      		$homirx_term_id = 15;
      		if ($terms) {
      			$term = current($terms);
      			$homirx_term_id = $term->term_id;
      		}
      	}
         $homirx_post = get_post($preview_post_id);
      }else{
      	$_submit_form_page = get_option( 'job_manager_submit_job_form_page_id', false );
      	if($_submit_form_page == $post_id && isset($_POST['job_manager_form']) && isset($_POST['submit_job']) && $_POST['job_manager_form'] == 'submit-job' && $_POST['submit_job'] ==  __( 'Preview', 'wp-job-manager' )){
				$homirx_post = get_post($homirx_job_preview);
			}else{
      		$homirx_post = $post;
      	}

      	//term_id
      	$object = get_queried_object();
         if(!empty($object)){
            $homirx_term_id = isset($object->term_id) && $object->term_id ? $object->term_id : 0;
         }
      }
   }

   protected function add_control_image_size($default, $key = 'homirx_image', $label = ''){
        if (empty($label)) {
            $label = esc_html__('Image Thumbnail', 'homirx-themer');
        }
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
               'name' => $key,
               'label' => $label,
               'default' => $default
            ]
        );
    }

  protected function add_control_carousel($columns_default, $condition = array()) {
	  	$this->start_controls_section(
			'section_carousel_options',
			[
				'label' => __('Carousel Options', 'homirx-themer'),
				'type'  => Controls_Manager::SECTION,
				'condition' => $condition,
			]
	  	);

	  	if($columns_default != 'always_single'){
		 	$this->add_control(
			 	'ca_items_lg',
			 	[
					'label'     => __('Columns for Large Screen', 'homirx-themer'),
					'type'      => Controls_Manager::SELECT,
					'default'   => isset($columns_default[0]) ? $columns_default[0] : 3,
					'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
			 	]
		 	);

		  	$this->add_control(
			 	'ca_items_md',
			 	[
					'label'     => __('Columns for Medium Screen', 'homirx-themer'),
					'type'      => Controls_Manager::SELECT,
					'default'   => isset($columns_default[1]) ? $columns_default[1] : 2,
					'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
			 	]
		  	);

			$this->add_control(
				'ca_items_sm',
				[
				  	'label'     => __('Columns for Small Screen', 'homirx-themer'),
				  	'type'      => Controls_Manager::SELECT,
				  	'default'   => isset($columns_default[2]) ? $columns_default[2] : 2,
				  	'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
				]
			);

			$this->add_control(
				'ca_items_xs',
				[
				  'label'     => __('Columns for Extra Small Screen', 'homirx-themer'),
				  'type'      => Controls_Manager::SELECT,
				  'default'   => isset($columns_default[3]) ? $columns_default[3] : 1,
				  'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
				]
			);

			$this->add_control(
				'ca_items_xx',
				[
				  'label'     => __('Columns for Very Extra Small Screen', 'homirx-themer'),
				  'type'      => Controls_Manager::SELECT,
				  'default'   => 1,
				  'options'   => array(1=>1, 2=>2, 3=>3)
				]
		 	);
		 	$this->add_control(
				'space_between',
				[
				  'label'     => __('Space Between Items', 'homirx-themer'),
				  'type'      => Controls_Manager::NUMBER,
					'default'	=> 30
				]
		 	);
		}  

		$this->add_control(
			'ca_effect',
			[
				'label'     => __('Effect', 'homirx-themer'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'slide',
				'options'   => array(
					'slide'		=>	__('Slide', 'homirx-themer'),
					'coverflow'	=>	__('coverflow', 'homirx-themer'),
				)
			]
		);
		$this->add_control(
			'ca_loop',
			[
				'label'     => __('Loop', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			]
		);

		$this->add_control(
			'ca_speed',
			[
				'label'     => __('Speed', 'homirx-themer'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 600,
			]
		);

		  $this->add_control(
			 'ca_autoplay',
			 [
				'label'     => __('Auto Play', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			 ]
		  );

		  $this->add_control(
			 'ca_autoplay_delay',
			 [
				'label'     => __('Auto Play Delay', 'homirx-themer'),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4500,
			 ]
		  );

		  $this->add_control(
			 'ca_autoplay_hover',
			 [
				'label'     => __('Play Hover', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			 ]
		  );

		  $this->add_control(
			 'ca_navigation',
			 [
				'label'     => __('Navigation', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes'
			 ]
		  );

		  $this->add_control(
			 'ca_pagination',
			 [
				'label'     => __('Pagination', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no'
			 ]
		  );

		$this->add_control(
		 	'ca_pagination_type',
		 	[
				'label'     => __('Pagination Type', 'homirx-themer'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'bullets',
				'options'   => array(
					'bullets'		=> esc_html__( 'Bullets', 'homirx-themer'),
					'fraction'		=> esc_html__( 'Fraction', 'homirx-themer'),
					'progressbar'	=> esc_html__( 'Progressbar', 'homirx-themer')
				)
			]
		);

		$this->add_control(
			'ca_dynamic_bullets',
			[
				'label'     => __('Dynamic Bullets', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no'
			]
		);

		$this->add_responsive_control(
		  'spacing_dots',
		  	[
			 	'label' => __( 'Dots Spacing', 'homirx-themer' ),
			 	'type' => Controls_Manager::SLIDER,
			 	'default' => [
					'size' => 0,
			 	],
			 	'range' => [
					'px' => [
					  	'min' => 0,
					  	'max' => 200,
					],
			 	],
			 	'selectors' => [
					'{{WRAPPER}} .swiper-slider-wrapper .swiper-pagination' => 'margin-top: {{SIZE}}px;',
			 	],
		  	]
		);
		
		$this->end_controls_section();
	 }

	 protected function add_control_grid($condition = array()) {
	  $this->start_controls_section(
		  'section_grid_options',
		  [
			 'label' => __('Grid Options', 'homirx-themer'),
			 'type'  => Controls_Manager::SECTION,
			 'condition' => $condition,
		  ]
	  );

	  $this->add_control(
		  'grid_items_lg',
		  [
			 'label'     => __('Columns for Large Screen', 'homirx-themer'),
			 'type'      => Controls_Manager::SELECT,
			 'default'   => 3,
			 'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
		  ]
	  );

		$this->add_control(
		  'grid_items_md',
		  [
			 'label'     => __('Columns for Medium Screen', 'homirx-themer'),
			 'type'      => Controls_Manager::SELECT,
			 'default'   => 3,
			 'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
		  ]
		);

		  $this->add_control(
			 'grid_items_sm',
			 [
				'label'     => __('Columns for Small Screen', 'homirx-themer'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 2,
				'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
			 ]
		  );

		  $this->add_control(
			 'grid_items_xs',
			 [
				'label'     => __('Columns for Extra Small Screen', 'homirx-themer'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 1,
				'options'   => array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6)
			 ]
		  );

		  $this->add_control(
			 'grid_items_xx',
			 [
				'label'     => __('Columns for Very Extra Small Screen', 'homirx-themer'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 1,
				'options'   => array(1=>1, 2=>2, 3=>3)
			 ]
		  );
  
		  $this->add_control(
			 'grid_remove_padding',
			 [
				'label'     => __('Remove Padding', 'homirx-themer'),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'no',
			 ]
		  );
		  $this->end_controls_section();
	 }

	protected function get_thumbnail_size(){
		global $_wp_additional_image_sizes; 
		$results = array(
			'full'      => 'full',
			'large'     => 'large',
			'medium'    => 'medium',
			'thumbnail' => 'thumbnail'
		);
	   foreach ($_wp_additional_image_sizes as $key => $size) {
			$results[$key] = $key;
	   }
		return $results;
	 }

   protected function get_carousel_options($options){
      $carousel_options = array(
        'items'               => isset($options['ca_items_lg']) ? intval($options['ca_items_lg']) : 1,
        'items_lg'            => isset($options['ca_items_lg']) ? intval($options['ca_items_lg']) : 1,
        'items_md'            => isset($options['ca_items_md']) ? intval($options['ca_items_md']) : 1,
        'items_sm'            => isset($options['ca_items_sm']) ? intval($options['ca_items_sm']) : 1,
        'items_xs'            => isset($options['ca_items_xs']) ? intval($options['ca_items_xs']) : 1,
        'items_xx'            => isset($options['ca_items_xx']) ? intval($options['ca_items_xx']) : 1,
        'effect'              => isset($options['ca_effect']) ? $options['ca_effect'] : 'slide',
        'space_between'       => isset($options['space_between']) ? intval($options['space_between']) : 20,
        'loop'                => $options['ca_loop'] === 'yes' ? 1 : 0,
        'speed'               => $options['ca_speed'],
        'autoplay'            => $options['ca_autoplay'] === 'yes' ? 1 : 0,
        'autoplay_delay'      => $options['ca_autoplay_delay'],
        'autoplay_hover'      => $options['ca_autoplay_hover'] === 'yes' ? 1 : 0,
        'navigation'          => $options['ca_navigation'] === 'yes' ? 1 : 0,
        'pagination'          => $options['ca_pagination'] === 'yes' ? 1 : 0,
        'dynamic_bullets'     => $options['ca_dynamic_bullets'] === 'yes' ? 1: 0,
        'pagination_type'     => $options['ca_pagination_type']
      );
      return $carousel_options;
   }

	protected function get_carousel_settings(){
		$settings = $this->get_settings_for_display();
		$carousel_options = $this->get_carousel_options($settings);
		return htmlspecialchars(json_encode($carousel_options));
	}

	 protected function get_carousel_single_settings(){
		$settings = $this->get_settings_for_display();
		$carousel_options = array(
		  'items'               => 1,
		  'items_lg'            => 1,
		  'items_md'            => 1,
		  'items_sm'            => 1,
		  'items_xs'            => 1,
		  'items_xx'            => 1,
		  'effect'					=> isset($settings['ca_effect']) ? $settings['ca_effect'] : 'slide',
		  'space_between'			=> isset($settings['space_between']) ? intval($settings['space_between']) : 20,
		  'loop'                => $settings['ca_loop'] === 'yes' ? 1 : 0,
		  'speed'               => $settings['ca_speed'],
		  'autoplay'           	=> $settings['ca_autoplay'] === 'yes' ? 1 : 0,
		  'autoplay_delay'   	=> $settings['ca_autoplay_delay'],
		  'autoplay_hover'     	=> $settings['ca_autoplay_hover'] === 'yes' ? 1 : 0,
		  'navigation'          => $settings['ca_navigation'] === 'yes' ? 1 : 0,
		  'pagination'          => $settings['ca_pagination'] === 'yes' ? 1 : 0,
		  'dynamic_bullets'		=> $settings['ca_dynamic_bullets'] === 'yes' ? 1: 0,
		  'pagination_type'		=> $settings['ca_pagination_type']
		);
		return htmlspecialchars(json_encode($carousel_options));
	 }

	protected function get_grid_settings($classes = '') {
	  	$settings = $this->get_settings_for_display();
	  	if($classes){
	     $this->add_render_attribute('grid', 'class', $classes);
	  	}
	  	$this->add_render_attribute('grid', 'class', 'lg-block-grid-' . $settings['grid_items_lg']);
	  	$this->add_render_attribute('grid', 'class', 'md-block-grid-' . $settings['grid_items_md']);
	  	$this->add_render_attribute('grid', 'class', 'sm-block-grid-' . $settings['grid_items_sm']);
	  	$this->add_render_attribute('grid', 'class', 'xs-block-grid-' . $settings['grid_items_xs']);
	  	$this->add_render_attribute('grid', 'class', 'xx-block-grid-' . $settings['grid_items_xx']);
	}


	 public function gva_render_button($classes = ''){
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['button_url']['url'] ) ) {
		  $this->add_render_attribute( 'button', 'href', $settings['button_url']['url'] );

		  if(!empty($classes)){
			 $this->add_render_attribute( 'button', 'class', $classes );
		  }else{
			 $this->add_render_attribute( 'button', 'class', 'btn-theme' );
		  }

		  if ( $settings['button_url']['is_external'] ) {
			 $this->add_render_attribute( 'button', 'target', '_blank' );
		  }
		  if ( $settings['button_url']['nofollow'] ) {
			 $this->add_render_attribute( 'button', 'rel', 'nofollow' );
		  }
		  ?>
		  <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
			 <span><?php echo esc_html( $settings['button_text'] ) ?></span>
		  </a>

		  <?php
		}
	 }

	 public function gva_render_link_begin($link = array(), $classes = ''){
		$r = gaviasthemer_random_id();
		if ( ! empty( $link['url'] ) ) {
		  $this->add_render_attribute( '_base_link_0' . $r, 'href', $link['url'] );

		  if(!empty($classes)){
			 $this->add_render_attribute( '_base_link_0' . $r, 'class', $classes );
		  }

		  if ( $link['is_external'] ) {
			 $this->add_render_attribute( '_base_link_0' . $r, 'target', '_blank' );
		  }
		  if ( $link['nofollow'] ) {
			 $this->add_render_attribute( '_base_link_0' . $r, 'rel', 'nofollow' );
		  }
		  ?>
		  <a <?php echo $this->get_render_attribute_string( '_base_link_0' . $r ); ?>>
		  <?php
		}
	 }

	 public function gva_render_link_end($link = array()){
		if ( ! empty( $link['url'] ) ) { 
		  echo '</a>';
		}
	 }

	public function gva_render_link_html($html = '', $link = array(), $classes = ''){ 
		$r = gaviasthemer_random_id();
		if ( ! empty( $link['url'] ) ) {
		  $this->add_render_attribute( '_base_link_1' . $r, 'href', $link['url'] );

		  if(!empty($classes)){
			 $this->add_render_attribute( '_base_link_1' . $r, 'class', $classes );
		  }

		  if ( $link['is_external'] ) {
			 $this->add_render_attribute( '_base_link_1' . $r, 'target', '_blank' );
		  }
		  if ( $link['nofollow'] ) {
			 $this->add_render_attribute( '_base_link_1' . $r, 'rel', 'nofollow' );
		  }
		  ?>
		  <a <?php echo $this->get_render_attribute_string( '_base_link_1' . $r ); ?>>
			 <?php echo $html; ?>
		  </a>
		  <?php
		}else{
		  echo $html;
		}
	}

	public function gva_render_link_html_2($html = '', $link = array(), $classes = ''){ 
		$r = gaviasthemer_random_id();
		if ( ! empty( $link['url'] ) ) {
		  $this->add_render_attribute( '_base_link_1' . $r, 'href', $link['url'] );

		  if(!empty($classes)){
			 $this->add_render_attribute( '_base_link_1' . $r, 'class', $classes );
		  }

		  if ( $link['is_external'] ) {
			 $this->add_render_attribute( '_base_link_1' . $r, 'target', '_blank' );
		  }
		  if ( $link['nofollow'] ) {
			 $this->add_render_attribute( '_base_link_1' . $r, 'rel', 'nofollow' );
		  }
		  ?>
		  <a <?php echo $this->get_render_attribute_string( '_base_link_1' . $r ); ?>>
			 <?php echo $html; ?>
		  </a>
		  <?php
		}
	}

	public function gva_render_link_overlay($link = array(), $classes = 'link-overlay'){
		$r = gaviasthemer_random_id();
		if ( ! empty( $link['url'] ) ) {
		  $this->add_render_attribute( '_base_link_1' . $r, 'href', $link['url'] );
		  $this->add_render_attribute( '_base_link_1' . $r, 'aria-label', 'link' );

		  if(!empty($classes)){
			 $this->add_render_attribute( '_base_link_1' . $r, 'class', $classes );
		  }

		  if ( $link['is_external'] ) {
			 $this->add_render_attribute( '_base_link_1' . $r, 'target', '_blank' );
		  }
		  if ( $link['nofollow'] ) {
			 $this->add_render_attribute( '_base_link_1' . $r, 'rel', 'nofollow' );
		  }
		  ?>
		  <a <?php echo $this->get_render_attribute_string( '_base_link_1' . $r ); ?>></a>
		  <?php
		}
	}


	public function get_template($template_name = null){
		$template_path = apply_filters('gva-elementor/template-path', 'templates/elementor/');
		$template = locate_template( $template_path . $template_name );
		if ( ! $template ){
			$template = GAVIAS_HOMIRX_PLUGIN_DIR  . 'elementor/views/' . $template_name;
		}
		if(file_exists($template)){
			return $template;
		}else{
			return false;
		}
	}

  	function homirx_get_template_part($slug, $name = null, $data = []){
		global $posts, $post;
		do_action( "get_template_part_{$slug}", $slug, $name );

		$templates = array();
		$name      = (string) $name;
		if ( '' !== $name ) {
			$templates[] = "{$slug}-{$name}.php";
		}

		$templates[] = "{$slug}.php";

		do_action( 'get_template_part', $slug, $name, $templates );
		$template = locate_template($templates, false);
	
		if (!$template) {
			return;
		}

		if ($data) {
			extract($data);
		}
	 
		include($template);
  	}

  	public function pagination( $query = false ){
	 	global $wp_query;   
	 	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

	 	if( ! $query ) $query = $wp_query;
	 
	 	$translate['prev'] =  esc_html__('Prev page', 'winnex');
	 	$translate['next'] =  esc_html__('Next page', 'winnex');
	 	$translate['load-more'] = esc_html__('Load more', 'winnex');
	 
	 	$query->query_vars['paged'] > 1 ? $current = $query->query_vars['paged'] : $current = 1;  
	 
	 	if( empty( $paged ) ) $paged = 1;
	 	$prev = $paged - 1;                         
	 	$next = $paged + 1;
	 
	 	$end_size = 1;
	 	$mid_size = 2;
	 	$show_all = false;
	 	$dots = false;

	 	if( ! $total = $query->max_num_pages ) $total = 1;
	 
	 	$output = '';
	 	if( $total > 1 ){   
			$output .= '<div class="column one pager_wrapper">';
			  $output .= '<div class="pager">';
				 $output .= '<div class="paginations">';
					if( $paged >1 && !is_home()){
					  $output .= '<a class="prev_page" href="'. previous_posts(false) .'"><i class="fas fa-chevron-left"></i></a>';
					}
					for( $i=1; $i <= $total; $i++ ){
					  if ( $i == $current ){
						 $output .= '<a href="'. get_pagenum_link($i) .'" class="page-item active">'. $i .'</a>';
						 $dots = true;
					  } else {
						 if ( $show_all || ( $i <= $end_size || ( $current && $i >= $current - $mid_size && $i <= $current + $mid_size ) || $i > $total - $end_size ) ){
							$output .= '<a href="'. get_pagenum_link($i) .'" class="page-item">'. $i .'</a>';
							$dots = true;
						 } elseif ( $dots && ! $show_all ) {
							$output .= '<span class="page-item">... </span>';
							$dots = false;
						 }
					  }
					}
					if( $paged < $total && !is_home()){
					  $output .= '<a class="next_page" href="'. next_posts(0,false) .'"><i class="fas fa-chevron-right"></i></a>';
					}
				 $output .= '</div>';
					
			  $output .= '</div>';
			$output .= '</div>'."\n";    
	 	}
	 
	 	return $output;
  	}

  	function image_attach($post_id, $key, $single = true, $thumbnail = 'thumbnail') {
	   $result = false;
	   $attach = get_post_meta($post_id, $key, $single);
	   if($attach){
	      if( !$single ){
	         $result = array();
	         foreach ($attach as $id) {
	            $result[] = wp_get_attachment_image_src($id, $thumbnail);
	         }
	      }else{
	         $result =  wp_get_attachment_image_src($attach, $thumbnail);
	      }
	   }
	   return $result;
	}
}