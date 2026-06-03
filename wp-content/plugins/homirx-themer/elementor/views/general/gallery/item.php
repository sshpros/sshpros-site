<?php
   use Elementor\Group_Control_Image_Size;

   $image_id = $image['image']['id']; 
   $image_url = $image['image']['url'];
   $image_url_thumbnail = $image['image']['url'];
   if($image_id){
      $attach_url = Group_Control_Image_Size::get_attachment_image_src($image_id, 'image', $settings);
      if($attach_url){
         $image_url_thumbnail = $attach_url;
      }
   }
   $style = $settings['style'];
?>
<?php if($style == 'style-1'){ ?>
   <div class="gallery-one__single">
      <?php if($image_url){ ?>
         <div class="gallery-one__image">
            <img src="<?php echo esc_url($image_url_thumbnail) ?>" alt="<?php echo esc_html($image['title']) ?>" />  
         </div>
         <a class="gallery-one__photo" href="<?php echo esc_url($image_url); ?>" data-elementor-lightbox-slideshow="gallery-<?php echo esc_attr($_random); ?>">
         	<i class="hicon-arrow-1"></i>
         </a>
      <?php } ?>

      <div class="gallery-one__content">
         <div class="gallery-one__content-inner">
         	<?php if($image['sub_title']){ ?>
               <div class="gallery-one__sub-title"><?php echo $image['sub_title'] ?></div>
            <?php } ?>
            <?php if($image['title']){ ?>
               <h3 class="gallery-one__title"><?php echo $image['title'] ?></h3>
            <?php } ?>
         </div>   
      </div>
   </div>
<?php } ?> 
<?php if($style == 'style-2'){ ?>
   <div class="gallery-two__single">
      <?php if($image_url){ ?>
         <div class="gallery-two__image">
            <img src="<?php echo esc_url($image_url_thumbnail) ?>" alt="<?php echo esc_html($image['title']) ?>" />  
         </div>
         <a class="gallery-two__photo" href="<?php echo esc_url($image_url); ?>" data-elementor-lightbox-slideshow="gallery-<?php echo esc_attr($_random); ?>"></a>
      <?php } ?>
   </div>
<?php } ?> 