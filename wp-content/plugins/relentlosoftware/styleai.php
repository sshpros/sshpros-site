<?php

/**
 * Plugin Name: StyleAI
 * Plugin URI: https://usestyle.ai
 * Description: Connect your Wordpress website to StyleAI and start automating and optimizing your digital marketing.
 * Version: 1.0.4
 * Requires at least: 4.4
 * Author: StyleAI
 * Author URI: https://usestyle.ai
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
  exit;
}

require_once(ABSPATH . 'wp-admin/includes/image.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');

class StyleAIPlugin
{
  private static $namespace = 'seona';
  private static $api = 'https://seonaapi.usestyle.ai/api';
  private static $version = '1.0.4';

  private static $key_endpoint;
  // private static $blog_post_endpoint;

  private static $identifier_option;
  private static $site_verification_token_option;

  public function __construct()
  {
    self::$key_endpoint = self::$api . '/keys/wordpress';
    // self::$blog_post_endpoint = self::$api . '/v3/blog-posts/sync/wordpress';

    self::$identifier_option = self::$namespace . '_identifier';
    self::$site_verification_token_option = self::$namespace . '_site_verification_token';

    add_action('activated_plugin', array($this, 'activated_plugin'));
    add_action('rest_api_init', array($this, 'rest_api_init'));
    add_action('post_updated', array($this, 'post_updated'));
    add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
    add_action('wp_head', array($this, 'wp_head'));
    add_filter('perfmatters_rest_api_exceptions', array($this, 'perfmatters_rest_api_exceptions'));
  }

  /**
   * Add the Seona namespace to the list of exceptions for the Perfmatters plugin
   */
  public function perfmatters_rest_api_exceptions()
  {
    $exceptions[] = self::$namespace;
    return $exceptions;
  }

  /**
   * Add the Google Site Verification token to the head
   */
  public function wp_head()
  {
    $token = get_option(self::$site_verification_token_option);

    if (!is_string($token) || strlen($token) === 0) return;

    echo '<meta name="google-site-verification" content="' . esc_html($token) . '">';
  }

  /**
   * Register endpoint routes
   */
  public function rest_api_init()
  {
    register_rest_route(self::$namespace, '/v1/authenticate', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => array($this, 'getIdentifier'),
      'permission_callback' => '__return_true'
    ));

    register_rest_route(self::$namespace, '/v1/site-verification-token', array(
      array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => array($this, 'getSiteVerificationToken'),
        'permission_callback' => '__return_true'
      ),
      array(
        'methods' => WP_REST_SERVER::EDITABLE,
        'callback' => array($this, 'updateSiteVerificationToken'),
        'permission_callback' => '__return_true'
      ),
      array(
        'methods' => WP_REST_SERVER::DELETABLE,
        'callback' => array($this, 'deleteSiteVerificationToken'),
        'permission_callback' => '__return_true'
      )
    ));

    register_rest_route(self::$namespace, '/v1/users', array(
      array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => array($this, 'getUsers'),
        'permission_callback' => '__return_true'
      ),
    ));

    register_rest_route(self::$namespace, '/v1/version', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => array($this, 'getVersion'),
      'permission_callback' => '__return_true'
    ));

    register_rest_route(self::$namespace, '/v1/posts/(?P<id>\d+)', array(
      array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => array($this, 'getPost'),
        'permission_callback' => '__return_true'
      ),
      array(
        'methods' => WP_REST_SERVER::EDITABLE,
        'callback' => array($this, 'updatePost'),
        'permission_callback' => '__return_true'
      ),
      array(
        'methods' => WP_REST_SERVER::DELETABLE,
        'callback' => array($this, 'deletePost'),
        'permission_callback' => '__return_true'
      )
    ));

    register_rest_route(self::$namespace, '/v1/posts', array(
      array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => array($this, 'getPosts'),
        'permission_callback' => '__return_true'
      ),
      array(
        'methods' => WP_REST_SERVER::EDITABLE,
        'callback' => array($this, 'insertPost'),
        'permission_callback' => '__return_true'
      )
    ));
  }

  /**
   * Generate a secure identifier for authentication
   */
  public function activated_plugin()
  {
    $current_identifier = get_option(self::$identifier_option);

    if ($current_identifier !== false) return;

    $identifier = bin2hex(random_bytes(16));
    add_option(self::$identifier_option, $identifier);
  }

  /**
   * Include the Seona JavaScript script on every page
   */
  public function wp_enqueue_scripts()
  {
    wp_enqueue_script('styleai', 'https://p.usestyle.ai', array(), null, array('strategy' => 'defer'));
  }

  /**
   * Get the encrypted identifier.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function getIdentifier()
  {
    $response = wp_remote_get(self::$key_endpoint);

    if (is_wp_error($response)) {
      return $response;
    }

    $public_key = wp_remote_retrieve_body($response);

    $identifier = get_option(self::$identifier_option);

    // Encrypt the identifier as a signature
    $result = openssl_public_encrypt($identifier, $encrypted_identifier, $public_key);

    if (!$result) {
      return new WP_Error('encrypt', 'Unable to encrypt identifier', array('status' => 500));
    }

    // Return the encoded signature
    return new WP_REST_Response(base64_encode($encrypted_identifier));
  }

  /**
   * Delete the Site Verification token.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function deleteSiteVerificationToken(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    $option_result = delete_option(self::$site_verification_token_option);

    if ($option_result === false) {
      return new WP_Error('delete-google-site-verification', 'Unable to delete Site Verification token', array('status' => 500));
    }

    return new WP_REST_Response(null, 204);
  }

  /**
   * Get the Site Verification token.
   *
   * @return WP_REST_Response The response object.
   */
  public function getSiteVerificationToken()
  {
    $token = get_option(self::$site_verification_token_option);

    if ($token === false) {
      return new WP_Error('get-google-site-verification', 'Unable to retrieve Site Verification token', array('status' => 404));
    }

    return new WP_REST_Response($token);
  }

  /**
   * Update the Google Site Verification token.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function updateSiteVerificationToken(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    $token = $request['token'];

    if (!is_string($token)) {
      return new WP_Error('update-google-site-verification', 'Unable to update the Site Verification token', array('status' => 400));
    }

    // Update the option
    update_option(self::$site_verification_token_option, $token);

    return new WP_REST_Response(null, 204);
  }

  /**
   * Get the users.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function getUsers(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    $users = get_users(array('role__in' => array('Editor', 'Administrator', 'Author')));

    return new WP_REST_Response($users);
  }

  /**
   * Handle post updates.
   * 
   * @param int id The post ID.
   * @param WP_Post post The post object.
   *
   * @return void
   */
  public function post_updated($id)
  {
    return;

    /* Get the post
    $post = get_post($id);

    if ($post === null || $post->post_type !== 'post') return;

    // Get the post meta
    $meta = get_post_meta($id, self::$namespace, true);

    if (!is_string($meta) || $meta !== "1") return;

    // Convert the post content to HTML
    $content = apply_filters('the_content', $post->post_content);

    // Get the website URL
    $url = get_site_url();

    // Get the post thumbnail
    $thumbnail = get_the_post_thumbnail_url($id);

    if ($thumbnail === false) {
      $thumbnail = null;
    }

    // Get the permanent link to the post
    $permalink = get_permalink($id);

    $filtered_post = $post->to_array();
    $filtered_post['post_content'] = $content;

    $data = array(
      'url' => $url,
      'thumbnail' => $thumbnail,
      'post' => $filtered_post,
      'permalink' => $permalink
    );

    wp_remote_post(self::$blog_post_endpoint, array(
      'body' => json_encode($data)
    ));*/
  }

  /**
   * Insert a post.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function insertPost(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    $upsert_result = self::upsertPost($request);

    if (is_wp_error($upsert_result)) {
      return $upsert_result;
    }

    $meta_result = add_post_meta($upsert_result, self::$namespace, "1");

    if ($meta_result === false) {
      return new WP_Error('upsert-post', 'Unable to insert post meta', array('status' => 500));
    }

    // Get a permanent link to the post
    $permalink = get_permalink($upsert_result);

    if ($permalink === false) {
      $permalink = null;
    }

    return new WP_REST_Response(array('ID' => $upsert_result, 'permalink' => $permalink));
  }

  /**
   * Get the plugin version.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_REST_Response The response object.
   */
  public function getVersion()
  {
    return new WP_REST_Response(self::$version);
  }

  /**
   * Update a post.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function updatePost(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    // Upsert the post
    $upsert_result = self::upsertPost($request);

    if (is_wp_error($upsert_result)) {
      return $upsert_result;
    }

    return new WP_REST_Response(null, 204);
  }

  /**
   * Delete a post.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function deletePost(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    $id = $request['id'];

    // Get the post meta
    $meta = get_post_meta($id, self::$namespace, true);

    if ($meta !== "1") {
      return new WP_Error('delete-post', 'Unable to retrieve post meta', array('status' => 400));
    }

    // Delete the post
    $delete_result = wp_delete_post($id, true);

    if ($delete_result === false) {
      return new WP_Error('delete-post', 'Unable to delete post', array('status' => 500));
    }

    return new WP_REST_Response(null, 204);
  }

  /**
   * Get a post.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function getPost(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    $id = $request['id'];

    // Get the post
    $post = get_post($id);

    if ($post === null) {
      return new WP_Error('get-post', 'Unable to retrieve post', array('status' => 404));
    }

    // Get the post meta
    $meta = get_post_meta($id, self::$namespace, true);

    if ($meta !== "1") {
      return new WP_Error('get-post', 'Unable to retrieve post meta', array('status' => 400));
    }

    // Get the post thumbnail
    $thumbnail = get_the_post_thumbnail_url($id);

    if ($thumbnail === false) {
      $thumbnail = null;
    }

    // Get the post content as HTML
    $content = apply_filters('the_content', $post->post_content);

    // Get the permanent link to the post
    $permalink = get_permalink($id);

    if ($permalink === false) {
      $permalink = null;
    }

    $filtered_post = $post->to_array();
    $filtered_post['post_content'] = $content;

    $data = array(
      'post' => $filtered_post,
      'thumbnail' => $thumbnail,
      'permalink' => $permalink
    );

    return new WP_REST_Response($data);
  }

  /**
   * Get posts.
   * 
   * @param WP_REST_Request request The request object.
   *
   * @return WP_Error|WP_REST_Response The response object.
   */
  public function getPosts(WP_REST_Request $request)
  {
    // Authenticate Seona
    $authenticate_result = self::authenticate($request);

    if (is_wp_error($authenticate_result)) {
      return $authenticate_result;
    }

    // Get the posts
    $posts = get_posts(array('meta_key' => self::$namespace));

    foreach ($posts as $post) {
      // Get the post thumbnail
      $thumbnail = get_the_post_thumbnail_url($post->ID);

      if ($thumbnail === false) {
        $thumbnail = null;
      }

      // Get the post content as HTML
      $content = apply_filters('the_content', $post->post_content);

      // Get the permanent link to the post
      $permalink = get_permalink($post->ID);

      if ($permalink === false) {
        $permalink = null;
      }

      $filtered_post = $post->to_array();
      $filtered_post['post_content'] = $content;

      $data[] = array(
        'post' => $filtered_post,
        'thumbnail' => $thumbnail,
        'permalink' => $permalink
      );
    }

    return new WP_REST_Response($data);
  }

  /**
   * Upsert a post.
   * 
   * @param WP_REST_Request request The request object.
   * 
   * @return WP_Error|int WP_Error if the post could not be upserted, or the post ID otherwise.
   */
  public function upsertPost(WP_REST_Request $request)
  {
    // Update the post
    $post = $request->get_body_params();

    if (isset($request['id'])) {
      $post['ID'] = $request['id'];
    }

    if (isset($_FILES['thumbnail'])) {
      // Create the attachment
      $attachment_result = media_handle_upload('thumbnail', 0);

      if (is_wp_error($attachment_result)) {
        return $attachment_result;
      }
    }

    // Update the post
    $post_result = wp_insert_post($post, true);

    if ($post_result === 0) {
      return new WP_Error('upsert-post', 'Unable to insert post', array('status' => 400));
    }

    if (is_wp_error($post_result)) {
      return $post_result;
    }

    if (isset($_FILES['thumbnail'])) {
      // Set the post thumbnail
      $thumbnail_result = set_post_thumbnail($post_result, $attachment_result);

      if ($thumbnail_result === false) {
        return new WP_Error('upsert-post', 'Unable to set thumbnail', array('status' => 500));
      }
    }

    return $post_result;
  }

  /**
   * Authenticate StyleAI.
   * 
   * @param WP_REST_Request request The request object.
   * @param bool header Whether to use the header or the request body.
   *
   * @return WP_Error|void WP_Error if the request is not authenticated, or void otherwise.
   */
  private function authenticate($request)
  {
    $signature = $request->get_header('Signature');

    if ($signature === null) {
      return new WP_Error('authenticate', 'Missing Signature header', array('status' => 400));
    }

    $identifier = get_option(self::$identifier_option);

    $response = wp_remote_get(self::$key_endpoint);
    $public_key = wp_remote_retrieve_body($response);

    // Verify the signature
    $verify_result = openssl_verify(
      $identifier,
      base64_decode($signature),
      $public_key,
      OPENSSL_ALGO_SHA512
    );

    if ($verify_result !== 1) {
      return new WP_Error('authenticate', 'Unauthorized', array('status' => 401));
    }
  }
}

new StyleAIPlugin();
