<?php
if ( ! defined( 'ABSPATH' ) ) {
   exit;
}

require_once __DIR__ . '/class-listing-floor-plan-field.php';

add_filter('atbdp_form_preset_widgets', 'test_form_preset_widgets');
function test_form_preset_widgets($fields){
   $fields['lt_floor_plan'] = [
      'label'   => 'Floor Plan',
      'icon'    => 'uil uil-user-arrows',
      'options' => [
         'type' => [
            'type'  => 'hidden',
            'value' => 'add_new',
         ],
         'field_key' => [
            'type'  => 'hidden',
            'value' => 'lt_floor_plan',
            'rules' => [
               'unique'   => true,
               'required' => true,
            ]
         ],
         'label' => [
            'type'  => 'text',
            'label' => __( 'Label', 'homirx-themer' ),
            'value' => 'Floor Plan',
         ],
         'required' => [
            'type'  => 'toggle',
            'label' => __( 'Required', 'homirx-themer' ),
            'value' => false,
         ],
         'only_for_admin' => [
            'type'  => 'toggle',
            'label' => __( 'Administrative Only', 'homirx-themer' ),
            'value' => false,
         ],
      ],
   ];

   $fields['lt_feature_list'] = [
      'label'   => 'Feature List',
      'icon'    => 'uil uil-text-fields',
      'options' => [
			'type' => [
				'type'  => 'hidden',
				'value' => 'textarea',
			],
			'field_key' => [
				'type'  => 'hidden',
				'label' => __( 'Key', 'homirx-themer' ),
				'value' => 'lt_feature_list',
				'rules' => [
					'unique'   => true,
					'required' => true,
				]
			],
			'label' => [
				'type'  => 'text',
				'label' => __( 'Label', 'homirx-themer' ),
				'value' => 'Feature List',
			],
			'description' => [
				'type'  => 'text',
				'label' => __( 'Description', 'homirx-themer' ),
				'value' => '',
			],
			'placeholder' => [
				'type'  => 'text',
				'label' => __( 'Placeholder', 'homirx-themer' ),
				'value' => '',
			],
			'rows' => [
				'type'  => 'number',
				'label' => __( 'Rows', 'homirx-themer' ),
				'value' => 8,
			],
			'required' => [
				'type'  => 'toggle',
				'label' => __( 'Required', 'homirx-themer' ),
				'value' => false,
			],
			'only_for_admin' => [
				'type'  => 'toggle',
				'label' => __( 'Administrative Only', 'homirx-themer' ),
				'value' => false,
			],
		]
   ];
   return $fields;
}
