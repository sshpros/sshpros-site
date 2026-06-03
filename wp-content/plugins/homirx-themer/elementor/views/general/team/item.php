<?php 
   use Elementor\Group_Control_Image_Size;

   $style = $settings['style'];
	$image_id = isset($item['image']['id']) && $item['image']['id'] ? $item['image']['id'] : 0; 
   $image_url = isset($item['image']['url']) && $item['image']['url'] ? $item['image']['url'] : '';
   $image_alt = $item['name'];
   if($image_id){
      $attach_url = wp_get_attachment_image_src( $image_id, $settings['image_size']);
      if(isset($attach_url[0]) && $attach_url[0]){
         $image_url = $attach_url[0];
      }
      $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
   }
   $name = $item['name'];
   
   $image = '<img src="' . esc_url($image_url) . '" alt="' . esc_html($image_alt) . '" />';

?>

<?php if($style == 'style-1'){ ?>
   <div class="team-one__single">
   	<?php if($image_url){ ?>
   		<div class="team-one__image">
            <?php echo $this->gva_render_link_html($image, $item['link'], 'link-content') ?>  
            
   		</div>
   	<?php } ?>	
      <div class="team-one__content">
         <div class="team-one__socials">
            <div class="team-one__social-links">
               <?php
                  $this->gva_render_link_html_2('<i class="fa fa-facebook"></i>', $item['facebook']);
                  $this->gva_render_link_html_2('<i class="fa fa-twitter"></i>', $item['twitter']);
                  $this->gva_render_link_html_2('<i class="fa fa-instagram"></i>', $item['instagram']);
                  $this->gva_render_link_html_2('<i class="fa fa-pinterest"></i>', $item['pinterest']);
               ?>
            </div> 
            <div class="team-one__social-control"><a><i class="fa-solid fa-share-nodes"></i></a></div>
         </div>
         <div class="team-one__content-inner">
      		<?php if($item['name']){ ?>
      			<h3 class="team-one__name">
                  <?php echo $this->gva_render_link_html($item['name'], $item['link']) ?>   
               </h3>
      		<?php } ?>
      		<?php if($item['position']){ ?>
      			<div class="team-one__job"><?php echo $item['position'] ?></div>
      		<?php } ?>
      		<?php 
	            if($item['phone']){
	         		echo '<div class="team-one__phone">';
	         			echo '<span>' . esc_html__('Call:', 'homirx-themer') . ' </span>';
	         			echo '<a href="tel:' . str_replace(' ', '', $item['phone']) . '">' . esc_html($item['phone']) . '</a>';
	         		echo '</div>';
	         	}
         	?>
            <?php if($item['desc']){ ?>
               <div class="team-one__desc"><?php echo $item['desc'] ?></div>
            <?php } ?>
      	</div>
      </div>
   </div>		
<?php } ?>
<?php if($style == 'style-2'){ ?>
   <div class="team-two__single">
      <?php if($image_url){ ?>
         <div class="team-two__image">
            <?php echo $this->gva_render_link_html($image, $item['link'], 'link-content') ?>  
            
         </div>
      <?php } ?>  
      <div class="team-two__content">
      	<?php 
      		if($item['phone']){
         		echo '<a class="team-two__phone" href="tel:'.esc_attr($item['phone']).'"><i class="hicon-phone-2"></i></a>';
         	}
         ?>
         <div class="team-two__social-links">
            <?php
               $this->gva_render_link_html_2('<i class="fa fa-facebook"></i>', $item['facebook']);
               $this->gva_render_link_html_2('<i class="fa fa-twitter"></i>', $item['twitter']);
               $this->gva_render_link_html_2('<i class="fa fa-instagram"></i>', $item['instagram']);
               $this->gva_render_link_html_2('<i class="fa fa-pinterest"></i>', $item['pinterest']);
            ?>
         </div>
         <div class="team-two__content-inner">
            <?php if($item['name']){ ?>
               <h3 class="team-two__name">
                  <?php echo $this->gva_render_link_html($item['name'], $item['link']) ?>   
               </h3>
            <?php } ?>
            <?php if($item['position']){ ?>
               <div class="team-two__job"><?php echo $item['position'] ?></div>
            <?php } ?>
            <?php if($item['desc']){ ?>
               <div class="team-two__desc"><?php echo $item['desc'] ?></div>
            <?php } ?>
         </div>
      </div>
   </div>      
<?php } ?>
<?php if($style == 'style-3'){ ?>
   <div class="team-three__single">
      <?php if($image_url){ ?>
         <div class="team-three__image">
            <?php echo $this->gva_render_link_html($image, $item['link'], 'link-content') ?>  
            
         </div>
      <?php } ?>  
      <div class="team-three__content">
         <div class="team-three__socials">
            <div class="team-three__social-control"><a><i class="fa-solid fa-share-nodes"></i></a></div>
            <div class="team-three__social-links">
               <?php
                  $this->gva_render_link_html_2('<i class="fa fa-facebook"></i>', $item['facebook']);
                  $this->gva_render_link_html_2('<i class="fa fa-twitter"></i>', $item['twitter']);
                  $this->gva_render_link_html_2('<i class="fa fa-instagram"></i>', $item['instagram']);
                  $this->gva_render_link_html_2('<i class="fa fa-pinterest"></i>', $item['pinterest']);
               ?>
            </div> 
         </div>
         <div class="team-three__content-inner">
            <?php if($item['name']){ ?>
               <h3 class="team-three__name">
                  <?php echo $this->gva_render_link_html($item['name'], $item['link']) ?>   
               </h3>
            <?php } ?>
            <?php if($item['position']){ ?>
               <div class="team-three__job"><?php echo $item['position'] ?></div>
            <?php } ?>
             <?php 
	            if($item['phone']){
	         		echo '<div class="team-three__phone">';
	         			echo '<span>' . esc_html__('Call:', 'homirx-themer') . ' </span>';
	         			echo '<a href="tel:' . str_replace(' ', '', $item['phone']) . '">' . esc_html($item['phone']) . '</a>';
	         		echo '</div>';
	         	}
         	?>
            <?php if($item['desc']){ ?>
               <div class="team-three__desc"><?php echo $item['desc'] ?></div>
            <?php } ?>
         </div>
      </div>
   </div>      
<?php } ?>