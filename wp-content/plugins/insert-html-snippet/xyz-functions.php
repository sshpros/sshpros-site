<?php
if ( ! defined( 'ABSPATH' ) ) 
	exit;

if(!function_exists('xyz_ihs_plugin_get_version'))
{
	function xyz_ihs_plugin_get_version() 
	{
		if ( ! function_exists( 'get_plugins' ) )
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		$plugin_folder = get_plugins( '/' . plugin_basename( dirname( XYZ_INSERT_HTML_PLUGIN_FILE ) ) );
		return $plugin_folder['insert-html-snippet.php']['Version'];
	}
}

if(!function_exists('xyz_ihs_run_upgrade_routines'))
{
function xyz_ihs_run_upgrade_routines() {
	global $wpdb;
	if (is_multisite()) {
		$blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
		foreach ($blog_ids as $blog_id) {
			switch_to_blog($blog_id);
			xyz_ihs_install();
			restore_current_blog();
		}
	} else {
		xyz_ihs_install();
	}
}
}
if(!function_exists('xyz_trim_deep'))
{

	function xyz_trim_deep($value) {
		if ( is_array($value) ) {
			$value = array_map('xyz_trim_deep', $value);
		} elseif ( is_object($value) ) {
			$vars = get_object_vars( $value );
			foreach ($vars as $key=>$data) {
				$value->{$key} = xyz_trim_deep( $data );
			}
		} else {
			$value = trim($value);
		}

		return $value;
	}

}


if(!function_exists('xyz_ihs_links')){
function xyz_ihs_links($links, $file) {
	$base = plugin_basename(XYZ_INSERT_HTML_PLUGIN_FILE);
	if ($file == $base) {

		$links[] = '<a href="https://xyzscripts.com/support/" class="xyz_ihs_support" title="Support"></a>';
		$links[] = '<a href="https://twitter.com/xyzscripts" class="xyz_ihs_twitt" title="Follow us on Twitter"></a>';
		$links[] = '<a href="https://www.facebook.com/xyzscripts" class="xyz_ihs_fbook" title="Like us on Facebook"></a>';
		$links[] = '<a href="https://www.instagram.com/xyz_scripts/" class="xyz_ihs_insta" title="Follow us on Instagram+"></a>';
		$links[] = '<a href="https://www.linkedin.com/company/xyzscripts" class="xyz_ihs_linkedin" title="Follow us on LinkedIn"></a>';
	}
	return $links;
}
}
add_filter( 'plugin_row_meta','xyz_ihs_links',10,2);
if(!function_exists('xyz_ihs_get_insertion_location_label')){
function xyz_ihs_get_insertion_location_label($value) {
    $map = array_flip(XYZ_IHS_INSERTION_LOCATION);

    if (!isset($map[$value])) {
        return '';
    }
    // Convert constant-style key to readable text
    return ucwords(strtolower(str_replace('_', ' ', $map[$value])));
	}
}
if(!function_exists('xyz_ihs_get_insertion_location_type_label')){
function xyz_ihs_get_insertion_location_type_label($value) {
    $map = array_flip(XYZ_IHS_INSERTION_LOCATION_TYPE);
    if (!isset($map[$value])) {
        return '';
    }
    return ucwords(strtolower(str_replace('_', ' ', $map[$value])));
}
}
	if(!function_exists('xyz_ihs_update_usage_for_post')){
	// --- Tracking Logic ---
	function xyz_ihs_update_usage_for_post($post_id, $content, $post_type = 'post') {
		global $wpdb;
		$table_name = $wpdb->prefix . 'xyz_ihs_usage';
		if (strpos($content, '[xyz-ihs') === false) {
			$wpdb->delete($table_name, ['post_id' => $post_id]);
			return;
		}
		$wpdb->delete($table_name, ['post_id' => $post_id]);
		preg_match_all('/\[xyz-ihs([^\]]*)\]/', $content, $shortcodes);
		$titles = [];
		if (!empty($shortcodes[1])) {
			foreach ($shortcodes[1] as $attr_string) {
				$atts = shortcode_parse_atts($attr_string);
				if (!empty($atts['snippet'])) {
					$titles[] = $atts['snippet'];
				}
			}
		}
		$unique_snippets = array_unique($titles);
		foreach ($unique_snippets as $title) {
			$s_id = $wpdb->get_var($wpdb->prepare(
				"SELECT id FROM {$wpdb->prefix}xyz_ihs_short_code WHERE title = %s",
				$title
			));
			if ($s_id) {
				$wpdb->insert($table_name, [
					'post_id'    => $post_id,
					'snippet_id' => $s_id,
					'post_type'  => $post_type
				]);
			}
		}
	}
	}
?>