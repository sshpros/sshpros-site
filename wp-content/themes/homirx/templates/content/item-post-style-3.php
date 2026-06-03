<?php 
   global $post;

   $thumbnail = (isset($thumbnail_size) && $thumbnail_size) ? $thumbnail_size : 'post-thumbnail';
   $excerpt_words = (isset($excerpt_words) && $excerpt_words) ? $excerpt_words : '0';

   $desc = homirx_limit_words($excerpt_words, get_the_excerpt(), '');

   $meta_classes = 'post-three__meta';
   if(empty(get_the_date())){
      $meta_classes = 'post-three__meta schedule-date';
   }
   $content_classes = 'post-three__content';
   $content_classes .= has_post_thumbnail() ? ' has-thumbnail' : ' has-no-thumbnail';
?>

   <article id="post-<?php echo esc_attr(get_the_ID()); ?>" <?php post_class('post post-three__single'); ?>>
      
      <?php if(has_post_thumbnail()){ ?>
         <div class="post-three__thumbnail">
            <a href="<?php echo esc_url( get_permalink() ) ?>">
               <?php the_post_thumbnail( $thumbnail, array( 'alt' => get_the_title() ) ); ?>
            </a>
            <?php if( get_the_date() ){ ?>
               <div class="post-three__entry-date">
                  <span class="post-three__date"><?php echo esc_html( get_the_date('d')) ?></span>
                  <span class="post-three__month"><?php echo esc_html( get_the_date('M')) ?></span>
               </div>
            <?php } ?>
         </div>   
      <?php } ?>   

      <div class="<?php echo esc_attr($content_classes) ?>">
         <div class="post-three__content-inner">
            
            <div class="<?php echo esc_attr($meta_classes) ?>">
               <?php homirx_posted_on(); ?>
            </div>

            <h3 class="post-three__title"><a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php the_title() ?></a></h3>
            
            <?php if($desc){ ?>
               <div class="post-three__desc">
                  <?php echo esc_html($desc) ?>
               </div>   
            <?php } ?>

            <div class="post-three__footer">
               <?php
                  if ( in_array( 'category', get_object_taxonomies(get_post_type())) ){
                     echo '<div class="post-three__category"><span class="cat-links"><i class="fa-solid fa-tags"></i>' . get_the_category_list( _x( ", ", "Used between list items, there is a space after the comma.", "homirx" ) ) . '</span></div>';
                  }
               ?>
               <div class="post-three__read-more">
                  <a href="<?php echo esc_url( get_permalink() ) ?>" aria-label="link"><i class="post-three__arrow  hicon-arrow-right-1"></i></a>
               </div>
            </div>   

         </div>
      </div>   
   </article>   

  