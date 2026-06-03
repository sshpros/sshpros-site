<?php
   use Elementor\Icons_Manager;
   
   $this->add_render_attribute( 'block', 'class', ['gva-navigation-mobile'] );
   $has_icon = ! empty( $settings['selected_icon']['value']);
?>

<div <?php echo $this->get_render_attribute_string( 'block' ) ?>>
   <div class="canvas-menu gva-offcanvas">
      <?php 
         if($has_icon){ 
            echo '<a class="dropdown-toggle" data-canvas=".mobile" href="#" aria-label="dropdown">';
               Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
            echo '</a>';
         }else{ 
            echo '<a class="dropdown-toggle" data-canvas=".mobile" href="#" aria-label="dropdown"><i class="fa-solid fa-bars"></i></a>';
         } 
      ?>
   </div>
</div>

