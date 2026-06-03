<?php 
   global $post;

   $thumbnail = (isset($thumbnail_size) && $thumbnail_size) ? $thumbnail_size : 'post-thumbnail';
   $excerpt_words = (isset($excerpt_words) && $excerpt_words) ? $excerpt_words : '0';

   $desc = homirx_limit_words($excerpt_words, get_the_excerpt(), '');

   $meta_classes = 'post-one__meta';
   if(empty(get_the_date())){
      $meta_classes = 'post-one__meta schedule-date';
   }
   $author_name = get_the_author_meta( 'display_name', $post->post_author );
   $content_classes = 'post-one__content';
   $content_classes .= has_post_thumbnail() ? ' has-thumbnail' : ' has-no-thumbnail';
?>

   <article id="post-<?php echo esc_attr(get_the_ID()); ?>" <?php post_class('post post-one__single'); ?>>
      
      <?php if(has_post_thumbnail()){ ?>
         <div class="post-one__thumbnail">
            <a href="<?php echo esc_url( get_permalink() ) ?>">
               <?php the_post_thumbnail( $thumbnail, array( 'alt' => get_the_title() ) ); ?>
            </a>
         </div>   
      <?php } ?>   

      <div class="<?php echo esc_attr($content_classes) ?>">
         <div class="post-one__content-inner">
            
            <div class="<?php echo esc_attr($meta_classes) ?>">
               <?php echo( '<span class="author vcard"><i class="hicon-user-3"></i>' . $author_name . '</span>'); ?>
               <?php if( get_the_date() ){ ?>
                  <span class="post-one__entry-date">
                     <i class=" hicon-calendar-1"></i>
                     <?php echo esc_html( get_the_date('d M y')) ?>
                  </span>
               <?php } ?>
            </div>

            <h3 class="post-one__title"><a href="<?php echo esc_url( get_permalink() ) ?>" rel="bookmark"><?php the_title() ?></a></h3>
            
            <?php 
            	if($desc){
            		echo '<div class="post-one__desc">' . esc_html($desc) . '</div>';
            	}
            ?>
            <div class="post-one__read-more">
               <a href="<?php echo esc_url( get_permalink() ) ?>" aria-label="link">
                  <?php echo esc_html__( 'Read More', 'homirx') ?><i class="hicon-right-arrow"></i></a>
            </div>

         </div>
      </div>   
   </article>   

  