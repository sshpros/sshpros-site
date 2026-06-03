<?php
if(!defined('ABSPATH')){ exit; }

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Repeater;

class GVAElement_Gallery_Property extends GVAElement_Base{

   const NAME = 'gva-gallery-property';
   const TEMPLATE = 'general/gallery-property';
   const CATEGORY = 'homirx_general';

   public function get_name() {
      return self::NAME;
   }

   public function get_categories() {
      return array(self::CATEGORY);
   }

	public function get_title() {
		return __('Gallery Property', 'homirx-themer');
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
         'image',
         [
            'label'       => __('Image', 'homirx-themer'),
            'type'        => Controls_Manager::MEDIA,
            'show_label' => false,
            'default'    => [
               'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/gallery-1.jpg',
            ]
         ]
      );
      $repeater->add_control(
         'image_second',
         [
            'label'       => __('Image Second', 'homirx-themer'),
            'type'        => Controls_Manager::MEDIA,
            'show_label' => false,
            'default'    => [
               'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/gallery-1.jpg',
            ]
         ]
      );
     	$repeater->add_control(
         'title',
         [
            'label'   => __('Title', 'homirx-themer'),
            'default' => esc_html__('Luxury Interior', 'homirx-themer'),
            'type'    => Controls_Manager::TEXT,
         ]
     	);
		$repeater->add_control(
         'address',
         [
            'label'   => __('Address', 'homirx-themer'),
            'default' => esc_html__('6391 Elgin St. Celina', 'homirx-themer'),
            'type'    => Controls_Manager::TEXT,
         ]
     	);
     	$repeater->add_control(
         'postcode',
         [
            'label'   => __('Post Code', 'homirx-themer'),
            'default' => esc_html__('16235', 'homirx-themer'),
            'type'    => Controls_Manager::TEXT,
         ]
     	);

		$this->add_control(
         'contents',
         [
            'label'       => __('Testimonials Content Item', 'homirx-themer'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ title }}}',
            'default'     => array(
              	array(
                  'image'    => [
                     'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/gallery-1.jpg',
                  ],
                  'title' => esc_html__('Hotel in Broklyn', 'homirx-themer'),
                  'sub_title' => esc_html__('Hotel', 'homirx-themer')
              	),
               array(
                  'image'    => [
                     'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/gallery-2.jpg',
                  ],
                  'title' => esc_html__('Shopping mall', 'homirx-themer'),
                  'sub_title' => esc_html__('Shopping', 'homirx-themer')
              	),
               array(
                  'image'    => [
                     'url' => GAVIAS_HOMIRX_PLUGIN_URL . 'elementor/assets/images/gallery-3.jpg',
                  ],
                  'title' => esc_html__('Hotel in Broklyn', 'homirx-themer'),
                  'sub_title' => esc_html__('Hotel', 'homirx-themer')
              	),
            )
         ]
      );

      $this->add_responsive_control(
			'min_height',
			[
				'label' 		=> esc_html__('Min Height', 'homirx-themer'),
				'type' 		=> Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .gallery-property-one' => 'min-height: {{SIZE}}{{UNIT}};',
					
				],
			]
		);

		$this->end_controls_section();

		$this->add_control_carousel(true);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		printf( '<div class="gva-element-%s gva-element">', $this->get_name() );
			include $this->get_template('general/gallery-property.php');
		print '</div>'; 

	}
}

$widgets_manager->register(new GVAElement_Gallery_Property());
