<?php

function homirx_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;

return $fields;
}
add_filter( 'comment_form_fields', 'homirx_move_comment_field_to_bottom' );

function homirx_comment_template($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		
		<div id="comment-<?php comment_ID(); ?>" class="the-comment media-comment">
			
			<div class="media-comment-left">
				<div class="author-image"><?php echo get_avatar($comment,$size='48'); ?></div>
			</div>

			<div class="comment-box media-comment-body">  
				
				<div class="author-meta">
				  <?php printf('<cite class="fn">%s</cite>', get_comment_author_link()) ?>
				  <span class="comment-info">
					 <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(esc_html__('%1$s', 'homirx'), get_comment_date()) ?></a>
				  </span>
				</div> 

				<?php if ($comment->comment_approved == '0') : ?>
				  <em><?php echo esc_html__('Your comment is awaiting moderation.', 'homirx') ?></em>
				  <br />
				<?php endif; ?>

				<div class="comment-body">
					<?php
						if(class_exists('Homirx_Listing_Comment_FE')){
							$review_avg = get_comment_meta($comment->comment_ID, 'lt_review_average', true);
							$review_result = Homirx_Listing_Comment_FE::getInstance()->star_review_by_comment($comment->comment_ID);
					 		if( !empty($review_result) ){      
								echo '<div class="comment-review-result">';
									echo '<span>' . html_entity_decode($review_result) . '</span>';
								echo '</div>';
							} 
						}
						comment_text(); 
					?>  
				</div>

				

				<div class="comment-action-wrap">
					<?php 
						
					 	$title = '<i class="far fa-edit"></i>' . esc_html__('Edit', 'homirx');
					 	edit_comment_link($title,'  ', '');
						$args['reply_text'] = '<i class="far fa-comment-dots"></i>' . esc_html__('Reply', 'homirx');
					 	comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));

				  	?>
				</div>

			</div>

		</div> 
	</li>  
<?php
}