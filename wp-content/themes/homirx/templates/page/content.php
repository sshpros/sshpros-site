<?php 
$page_template = get_page_template_slug();
if(have_posts()) : the_post(); 
   the_content(); 
endif;
