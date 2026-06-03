<?php
add_filter('directorist_listing_header_layout', 'homirx_themer_single_header');
function homirx_themer_single_header($data){
	$data['layout'] = [
     	[
         'type' => 'placeholder_group',
         'placeholderKey' => 'quick-widgets-placeholder',
         'placeholders' => [
             [
                 'type'              => 'placeholder_item',
                 'placeholderKey'    => 'quick-info-placeholder',
                 'label'             => __( 'Quick info', 'homirx-themer' ),
                 'maxWidget'         => 2,
                 'maxWidgetInfoText' => "Up to __DATA__ item{s} can be added",
                 'acceptedWidgets'   => ['back', 'lt_title'],
             ],
             [
                 'type'              => 'placeholder_item',
                 'placeholderKey'    => 'quick-action-placeholder',
                 'label'             => __( 'Quick Action', 'homirx-themer' ),
                 'maxWidget'         => 0,
                 'maxWidgetInfoText' => "Up to __DATA__ item{s} can be added",
                 'acceptedWidgets'   => [ 'bookmark', 'share', 'report' ],
             ],
         ],
     	],
     	[
         'type'              => 'placeholder_item',
         'placeholderKey'    => 'listing-title-placeholder',
         'label'             => __( 'Listing Title', 'homirx-themer' ),
         'maxWidget'         => 1,
         'maxWidgetInfoText' => "Up to __DATA__ item{s} can be added",
         'acceptedWidgets'   => ['title'],
     	],
     	[
         'type'              => 'placeholder_item',
         'placeholderKey'    => 'more-widgets-placeholder',
         'label'             => __( 'More Widgets', 'homirx-themer' ),
         'maxWidget'         => 0,
         'maxWidgetInfoText' => "Up to __DATA__ item{s} can be added",
         'acceptedWidgets'   => [ 'location', 'category', 'ratings_count', 'badges', 'price' ],
         'rejectedWidgets'   => ['slider'],
     	],
     	[
         'type'            => 'placeholder_item',
         'label'           => 'Slider Widget',
         'placeholderKey'  => 'slider-placeholder',
         'selectedWidgets' => ['slider'],
         'acceptedWidgets' => ['slider'],
         'maxWidget'       => 1,
         'canDelete'       => true,
         'insertByButton'  => true,
         'insertButton'    => [
           'label' => 'Add Image/Slider'
         ]
     	]
 	];

 	$data['widgets']['lt_title'] = [
      'type' => "badge",
      'label' => __( "Title", 'homirx-themer' ),
      'options' => [
        	'title' => __( "Title Settings", "homirx-themer" ),
        	'fields' => [
           	'enable_tagline' => [
               'type' => "toggle",
               'label' => __( "Show Tagline", "homirx-themer" ),
               'value' => true,
           	],
            'enable_address' => [
               'type' => "toggle",
               'label' => __( "Enable Address", "homirx-themer" ),
               'value' => true,
            ]
        	]
      ]
   ];

	return $data;
}

function homirx_themer_single_content_widgets(){
	return $single_listings_contents_widgets = [
      'preset_widgets' => [
          'title'         => __( 'Preset Fields', 'homirx-themer' ),
          'description'   => __( 'Click on a field to use it', 'homirx-themer' ),
          'allowMultiple' => false,
          'template'      => 'submission_form_fields',
          'widgets'       => apply_filters( 'atbdp_single_listing_content_widgets', [
              'tag'          => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-tag',
                      ],
                  ],
              ],
              'address'      => [
                  'options' => [
                      'icon'                  => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-map',
                      ],
                      'address_link_with_map' => [
                          'type'  => 'toggle',
                          'label' => __( 'Address Linked with Map', 'homirx-themer' ),
                          'value' => false,
                      ],
                  ],
              ],
              'map'          => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-map',
                      ],
                  ],
              ],
              'zip'          => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-street-view',
                      ],
                  ],
              ],
              'phone'        => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-phone',
                      ],
                  ],
              ],
              'phone2'       => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-phone',
                      ],
                  ],
              ],
              'fax'          => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-fax',
                      ],
                  ],
              ],
              'email'        => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-envelope',
                      ],
                  ],
              ],
              'website'      => [
                  'options' => [
                      'icon'         => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-globe',
                      ],
                      'use_nofollow' => [
                          'type'  => 'toggle',
                          'label' => __( 'Use rel="nofollow" in Website Link', 'homirx-themer' ),
                          'value' => false,
                      ],
                  ],
              ],
              'social_info'  => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-share-alt',
                      ],
                  ],
              ],
              'video'        => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-video',
                      ],
                  ],
              ],
              'text'         => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-text-height',
                      ],
                  ],
              ],
              'textarea'     => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-align-center',
                      ],
                  ],
              ],
              'number'       => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-list-ol',
                      ],
                  ],
              ],
              'url'          => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-link',
                      ],
                  ],
              ],
              'date'         => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-calendar',
                      ],
                  ],
              ],
              'time'         => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-clock',
                      ],
                  ],
              ],
              'color_picker' => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-palette',
                      ],
                  ],
              ],
              'select'       => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-clipboard-check',
                      ],
                  ],
              ],
              'checkbox'     => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-check-square',
                      ],
                  ],
              ],
              'radio'        => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-circle',
                      ],
                  ],
              ],
              'file'         => [
                  'options' => [
                      'icon' => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-file-alt',
                      ],
                  ],
              ],
          ] ),
      ],
      'other_widgets'  => [
          'title'         => __( 'Other Fields', 'homirx-themer' ),
          'description'   => __( 'Click on a field to use it', 'homirx-themer' ),
          'allowMultiple' => false,
          'widgets'       => apply_filters( 'atbdp_single_listing_other_fields_widget', [
              'custom_content'         => [
                  'type'          => 'widget',
                  'label'         => __( 'Custom Content', 'homirx-themer' ),
                  'icon'          => 'las la-align-right',
                  'allowMultiple' => true,
                  'options'       => [
                      'label'   => [
                          'type'  => 'text',
                          'label' => __( 'Label', 'homirx-themer' ),
                          'value' => '',
                      ],
                      'icon'    => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => '',
                      ],
                      'content' => [
                          'type'        => 'textarea',
                          'label'       => __( 'Content', 'homirx-themer' ),
                          'value'       => '',
                          'description' => __( 'You can use any text or shortcode', 'homirx-themer' ),
                      ],
                  ],
              ],
              'author_info'            => [
                  'type'    => 'section',
                  'label'   => __( 'Author Info', 'homirx-themer' ),
                  'icon'    => 'las la-user',
                  'options' => [
                      'label'                => [
                          'type'  => 'text',
                          'label' => __( 'Label', 'homirx-themer' ),
                          'value' => 'Author Info',
                      ],
                      'custom_block_id'      => [
                          'type'  => 'text',
                          'label' => __( 'Custom block ID', 'homirx-themer' ),
                          'value' => '',
                      ],
                      'custom_block_classes' => [
                          'type'  => 'text',
                          'label' => __( 'Custom block Classes', 'homirx-themer' ),
                          'value' => '',
                      ],
                  ],
              ],
              'contact_listings_owner' => [
                  'type'    => 'section',
                  'label'   => __( 'Contact Listings Owner Form', 'homirx-themer' ),
                  'icon'    => 'las la-phone',
                  'options' => [
                      'label'                => [
                          'type'  => 'text',
                          'label' => __( 'Label', 'homirx-themer' ),
                          'value' => 'Contact Listings Owner Form',
                      ],
                      'icon'                 => [
                          'type'  => 'icon',
                          'label' => __( 'Icon', 'homirx-themer' ),
                          'value' => 'las la-phone',
                      ],
                      'custom_block_id'      => [
                          'type'  => 'text',
                          'label' => __( 'Custom block ID', 'homirx-themer' ),
                          'value' => '',
                      ],
                      'custom_block_classes' => [
                          'type'  => 'text',
                          'label' => __( 'Custom block Classes', 'homirx-themer' ),
                          'value' => '',
                      ],
                  ],
              ],
          ] ),
      ],
  ];
}

add_filter('atbdp_single_listing_content_widgets', 'homirx_themer_single_listings_contents_widgets');
function homirx_themer_single_listings_contents_widgets($data){
	$data['lt_feature_list']= array(
		'options' => [
         'class' => [
            'type'  => 'text',
            'label' => __( 'Classes', 'homirx-themer' ),
            'value' => ''
         ],
      ],
	);
	$data['lt_floor_plan']= array(
		'options' => [
         'class' => [
            'type'  => 'text',
            'label' => __( 'Classes', 'homirx-themer' ),
            'value' => ''
         ],
      ],
	);
	return $data;
}

add_filter('atbdp_listing_type_settings_field_list', 'homirx_themer_listings_field_list');
function homirx_themer_listings_field_list($data){
	$data['single_listings_sidebar'] = [
      'type'            => 'form-builder',
      'widgets'         => homirx_themer_single_content_widgets(),
      'generalSettings' => [
         'addNewGroupButtonLabel' => __( 'Add Section', 'homirx-themer' ),
      ],
      'groupFields'     => [
         'section_id'           => [
            'type'    => 'text',
            'disable' => true,
            'label'   => 'Section ID',
            'value'   => '',
        	],
        	'icon'                 => [
            'type'  => 'icon',
            'label' => __( 'Block/Section Icon', 'homirx-themer' ),
            'value' => '',
        	],
        	'label'                => [
            'type'  => 'text',
            'label' => __( 'Label', 'homirx-themer' ),
            'value' => 'Section',
        	],
        	'custom_block_id'      => [
            'type'  => 'text',
            'label' => __( 'Custom block ID', 'homirx-themer' ),
            'value' => '',
        	],
        	'custom_block_classes' => [
            'type'  => 'text',
            'label' => __( 'Custom block Classes', 'homirx-themer' ),
            'value' => '',
        ],
        'shortcode'            => [
            'type'        => 'shortcode-list',
            'label'       => __( 'Shortcode', 'homirx-themer' ),
            'description' => __( 'Click the wizerd button to generate the shortcode.', 'homirx-themer' ),
            'buttonLabel' => '<i class="fas fa-magic"></i>',
            'shortcodes'  => [
               [
                  'shortcode' => '[directorist_single_listing_section label="@@shortcode_label@@" key="@@shortcode_key@@"]',
                  'mapAtts'   => [
                     [
                        'map'   => 'self.section_id',
                        'where' => [
                           'key'   => 'value',
                           'mapTo' => '@@shortcode_key@@',
                        ],
                     ],
                     [
                        'map'   => 'self.label',
                        'where' => [
                           'key'   => 'value',
                           'mapTo' => '@@shortcode_label@@',
                        ]
                     ]
                  ]
               ]
            ],
            'show_if'     => [
               'where'      => 'enable_single_listing_page',
               'conditions' => [
                  ['key' => 'value', 'compare' => '=', 'value' => true],
               ]
            ]
        	]
      ],
      'value'    => [],
   ];
	return $data;
}

add_filter('directorist_builder_layouts', 'homirx_themer_builder_layouts', 10, 2);
function homirx_themer_builder_layouts($data){
	$data['single_page_layout']['submenu']['sidebar'] = array(
      'label'     => __( 'Sidebar', 'homirx-themer' ),
      'container' => 'wide',
      'sections'  => [
         'contents' => [
            'title'       => __( 'Sidebar', 'homirx-themer' ),
            'description' => '<a target="_blank" href="https://directorist.com/documentation/directorist/form-and-layout-builder/single-listings-layout/"> ' . __( 'Need help?', 'homirx-themer' ) . ' </a>',
            'fields'      => [
               'single_listings_sidebar',
            ]
         ]
      ]
	);
	return $data;
}

function homirx_themer_single_data($data, $type) {
	$content_data           = array();
	$single_fields          = $data;
	$submission_form_fields = get_term_meta( $type, 'submission_form_fields', true );

	if( !empty( $single_fields['fields'] ) ) {

		foreach ( $single_fields['fields'] as $key => $value ) {
			if ( ! is_array( $value ) ) {
				continue;
			}

			// If 'other_widgets', then no need to set values from submission form fields
			if ( $value['widget_group'] === 'other_widgets' ) {
				continue;
			}

			// Make sure form key name is valid
			if ( !isset( $value['original_widget_key'] ) ) {
				unset( $single_fields['fields'][$key] );
				continue;
			}

			$form_key = $value['original_widget_key'];

			// Make sure the same form field exists
			if ( empty( $submission_form_fields['fields'][$form_key] ) ) {
				unset( $single_fields['fields'][$key] );
				continue;
			}

			$single_fields['fields'][$key]['field_key'] = '';
			$single_fields['fields'][$key]['options'] = [];

			unset( $single_fields['fields'][$key]['widget_key'] );
			unset( $single_fields['fields'][$key]['original_widget_key'] );

			// Added form_field, field_key, label, widget_group from submission form
			$form_data = $submission_form_fields['fields'][$form_key];

			$single_fields['fields'][$key]['form_data'] = $form_data;

			if ( !empty( $form_data['field_key'] ) ) {
				$single_fields['fields'][$key]['field_key'] = $form_data['field_key'];
			}

			if ( !empty( $form_data['options'] ) ) {
				$single_fields['fields'][$key]['options'] = $form_data['options'];
			}

			$single_fields['fields'][$key]['label'] = !empty( $form_data['label'] ) ? $form_data['label'] : '';

			if( !empty( $form_data['widget_group'] ) ) {
				$single_fields['fields'][$key]['widget_group'] = $form_data['widget_group'];
			}
		}
	}

	if( !empty( $single_fields['groups'] ) ) {
		foreach ( $single_fields['groups'] as $group ) {
			$section           = $group;
			$section['fields'] = array();
			foreach ( $group['fields'] as $field ) {
				if ( ! isset( $single_fields['fields'][ $field ] ) ) {
					continue;
				}
				$section['fields'][ $field ] = $single_fields['fields'][ $field ];
			}
			$content_data[] = $section;
		}
	}
	
	return $content_data;
}

