<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 8.0
 */
use Directorist\database\DB;

if ( ! defined( 'ABSPATH' ) ) exit;

$is_blur           = get_directorist_option('prv_background_type', 'blur');
$is_blur           = ('blur' === $is_blur ? true : false);
$container_size_by = get_directorist_option('prv_container_size_by', 'px');
$by_ratio          = ( 'px' === $container_size_by ) ? false : true;
$image_size        = get_directorist_option('way_to_show_preview', 'cover');
$ratio_width       = get_directorist_option('crop_width', 360);
$ratio_height      = get_directorist_option('crop_height', 300);
$blur_background   = $is_blur;
$background_color  = get_directorist_option('prv_background_color', '#fff');

// Style
$style_component = [];

if ( $by_ratio ) {
	$padding_top_value = (int) $ratio_height / (int) $ratio_width * 100;
	$style_component[ 'padding-top' ] = "{$padding_top_value}%";
} else {
	$height_value = (int) $ratio_height;
	$style_component[ 'height' ] = "{$height_value}px";
}
if ( $image_size !== 'full' && ! $blur_background ) {
	$style_component[ 'background-color' ] = $background_color;
}
if ( $image_size === 'full' ) {
	unset( $style_component[ 'height' ] );
}

$style = '';
foreach ( $style_component as $style_prop => $style_value ) {
	$style .= "{$style_prop}: {$style_value};";
}

//Only Image
$front_wrap_html = '';

$default_image_src = Directorist\Helper::default_preview_image_src( $listings->current_listing_type );

$id = get_the_ID();
$image_quality     = get_directorist_option('preview_image_quality', 'directorist_preview');
$listing_prv_img   = get_post_meta($id, '_listing_prv_img', true);


$link_start = '<a href="'.esc_url( apply_filters( 'directorist_archive_single_listing_url', $listings->loop['permalink'], $listings->loop['id'], 'thumbnail' ) ).'">';
$link_end   = '</a>';

// Image
if ( empty( $listing_prv_img ) ) {
	$image     = "<img src='$default_image_src' alt='$image_alt' class='$class' />";
}else{
	$image_src  = atbdp_get_image_source( $listing_prv_img, $image_quality );
	$image_alt  = get_post_meta( $listing_prv_img, '_wp_attachment_image_alt', true );
	$image_alt  = ( ! empty( $image_alt ) ) ? esc_attr( $image_alt ) : esc_html( get_the_title( $listing_prv_img ) );
	$image      = "<img src='$image_src' alt='$image_alt' />";
}

$front_wrap_html = $link_start . $image . $link_end;

// Card Contain
$card_contain_wrap = "<div class='directorist-thumnail-card directorist-card-contain' style='$style'>";
$image_contain_html = $card_contain_wrap  . $front_wrap_html . "</div>";

// Card Cover
$card_cover_wrap = "<div class='directorist-thumnail-card directorist-card-cover' style='$style'>";
$image_cover_html = $card_cover_wrap . $front_wrap_html . "</div>";

// Card Full
$card_full_wrap = "<div class='directorist-thumnail-card directorist-card-full' style='$style'>";
$image_full_html = $card_full_wrap . $front_wrap_html . "</div>";

$the_html = $image_cover_html;
switch ($image_size) {
	case 'cover':
	$the_html = $image_cover_html;
	break;
	case 'contain':
	$the_html = $image_contain_html;
	break;
	case 'full':
	$the_html = $image_full_html;
	break;
}

echo wp_kses_post( $the_html );
