<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Repeater;

class GVAElement_Review_Box extends GVAElement_Base{

   const NAME = 'gva-review-box';
   const TEMPLATE = 'general/review-box';
   const CATEGORY = 'homirx_general';

   public function get_name() {
      return self::NAME;
   }

   public function get_categories() {
      return array(self::CATEGORY);
   }

	public function get_title() {
		return __('Review Box', 'homirx-themer');
	}
	public function get_keywords() {
		return [ 'gallery', 'property' ];
	}

	public function get_script_depends() {
      return [
         'swiper',
         'gavias.elements',
      ];
   }

   public function get_style_depends() {
      return array('swiper');
   }

	protected function register_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __('Query & Layout', 'homirx-themer'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
         'title',
         [
            'label'   => __('Title', 'homirx-themer'),
            'default' => esc_html__('Trustipilot', 'homirx-themer'),
            'type'    => Controls_Manager::TEXT,
         ]
     	);
     	$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'homirx-themer' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style-1' 		=> __( 'Style 01', 'homirx-themer' ),
					'style-2' 		=> __( 'Style 02', 'homirx-themer' ),
				],
				'default' => 'style-1'
			]
		);
     	$repeater->add_control(
			'selected_icon',
			[
				'label'      	=> esc_html__('Choose Icon', 'homirx-themer'),
				'type'       	=> Controls_Manager::ICONS,
				'default' 		=> [
					'value' 		=> 'fas fa-star',
					'library' 	=> 'fa-solid'
				]
			]
		);
		$repeater->add_control(
         'image',
         [
            'label'       => __('Image', 'homirx-themer'),
            'type'        => Controls_Manager::MEDIA,
            'show_label' => false,
            'default'    => [
               'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/avatar.png',
            ]
         ]
      );
		$repeater->add_control(
         'review',
         [
            'label'   => __('Review Star', 'homirx-themer'),
            'type'    => Controls_Manager::NUMBER,
            'min'		 => 1,
            'max'	    => 5,
            'step'    => 1,
            'default' => 5
         ]
     	);
 		$repeater->add_control(
         'desc',
         [
            'label'   => __('Description', 'homirx-themer'),
            'default' => esc_html__('450+ reviews', 'homirx-themer'),
            'type'    => Controls_Manager::TEXT,
         ]
     	);
		$this->add_control(
         'contents',
         [
            'label'       => __('Content Item', 'homirx-themer'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'     => array(
              	array(
                  'title' => esc_html__('Trustipilot', 'homirx-themer'),
              	),
               array(
                  'title' => esc_html__('Google', 'homirx-themer'),
              	),
            )
         ]
      );

		$this->end_controls_section();

		$this->add_control_carousel(true);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		printf( '<div class="gva-element-%s gva-element">', $this->get_name() );
			include $this->get_template('general/review-box.php');
		print '</div>'; 

	}
}

$widgets_manager->register(new GVAElement_Review_Box());
