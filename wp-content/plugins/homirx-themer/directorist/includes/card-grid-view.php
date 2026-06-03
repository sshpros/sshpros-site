<?php
add_filter( 'directorist_listing_card_layouts', 'homirx_listing_card_layouts', 99, 2);
add_filter( 'directorist_listing_card_widgets', 'homirx_listing_card_widgets', 99, 2);

function homirx_listing_card_layouts($layout){
   if(isset($layout['card_templates']['grid_view_with_thumbnail']['layout']['body']['bottom']['acceptedWidgets'])){
      $layout['card_templates']['grid_view_with_thumbnail']['layout']['body']['bottom']['acceptedWidgets'] = array(
        'listings_location', 'phone', 'phone2', 'website', 'zip', 'fax', 'address', 'email',
         'text', 'textarea', 'number', 'url', 'date', 'time', 'color', 'select', 'checkbox', 'radio', 'file', 'posted_date', 'excerpt'
      );
   }
   if(isset($layout['card_templates']['grid_view_with_thumbnail']['layout']['body']['excerpt'])){
      $layout['card_templates']['grid_view_with_thumbnail']['layout']['body']['excerpt'] = array(
         'maxWidget'          => 5,
         'acceptedWidgets'    => ['excerpt', 'text', 'number']
      );
   }
   if(isset($layout['card_templates']['grid_view_with_thumbnail']['layout']['footer'])){
      $layout['card_templates']['grid_view_with_thumbnail']['layout']['footer'] = array(
         'right' => [
            'maxWidget'          => 3,
            'acceptedWidgets'    => ['category', 'favorite_badge', 'view_count', 'listing_link']
         ],
         'left' => [
            'maxWidget'       => 3,
            'acceptedWidgets' => ['pricing', 'category', 'favorite_badge', 'view_count', 'listing_link']
         ]
      );
   }
   if(isset($layout['card_templates']['grid_view_with_thumbnail']['layout']['body']['top']['acceptedWidgets'])){
      $layout['card_templates']['grid_view_with_thumbnail']['layout']['body']['top']['acceptedWidgets'] = array(
         'listing_title', 'favorite_badge', 'popular_badge', 'featured_badge', 'new_badge', 'rating', 'pricing', 'excerpt', 'address'
      );
   }
   return $layout;
}

function homirx_listing_card_widgets($widgets){
   if(isset($widgets['excerpt']['type'])){
      $widgets['excerpt']['type'] = 'list-item';
   }
   $widgets['listing_link']  = [
      'type'    => 'price',
      'widget_name'   => 'listing_link',
      'label'   => __( 'Listing Link', 'homirx-themer' ),
      'icon'    => 'las la-link',
      'hook'    => 'atbdp_listing_link',
      'options' => [
         'title'  => __( 'Settings', 'homirx-themer' ),
         'fields' => [
            'label_link' => [
               'type'  => 'text',
               'label' => __( 'Label', 'homirx-themer' ),
               'value' => 'Details',
            ],
            'icon'       => [
               'type'  => 'text',
               'label' => __( 'Icon', 'homirx-themer' ),
               'value' => ' hicon-home'
            ]
         ]
      ]
   ];

   if(isset($widgets['number']['options']['fields']['icon']['type'])){
      $widgets['number']['options']['fields']['icon']['type'] = 'text';
   }
      if(isset($widgets['text']['options']['fields']['icon']['type'])){
      $widgets['text']['options']['fields']['icon']['type'] = 'text';
   }
   return $widgets;
}