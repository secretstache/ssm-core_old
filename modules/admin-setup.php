<?php

namespace SSMCore\AdminSetup;

/**
 * Remove Unnecessary User Roles
 * @since 1.0.0
 */

function remove_roles() {

  remove_role( 'subscriber' );
  remove_role( 'contributor' );

}

add_action('init', __NAMESPACE__ . '\\remove_roles');


/**
 * Remove default link for images
 * @since 1.0.0
 */
function remove_image_link() {
  $image_set = get_option( 'image_default_link_type' );
  if ($image_set !== 'none') {
    update_option('image_default_link_type', 'none');
  }
}

add_action('admin_init', __NAMESPACE__ . '\\remove_image_link', 10);


/**
 * Show Kitchen Sink in WYSIWYG Editor by default
 * @since 1.0.0
 */
function show_kitchen_sink($args) {
  $args['wordpress_adv_hidden'] = false;
  return $args;
}

add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\show_kitchen_sink' );


/**
 * Disable unused widgets.
 * @since 1.0.0
 */
function remove_widgets() {

  unregister_widget( 'WP_Widget_Pages' );
  unregister_widget( 'WP_Widget_Calendar' );
  unregister_widget( 'WP_Widget_Archives' );
  unregister_widget( 'WP_Widget_Meta' );
  unregister_widget( 'WP_Widget_Recent_Posts' );
  unregister_widget( 'WP_Widget_Recent_Comments' );
  unregister_widget( 'WP_Widget_RSS' );
  unregister_widget( 'WP_Widget_Tag_Cloud' );

}

add_action('widgets_init', __NAMESPACE__ . '\\remove_widgets');


/**
 * Modifies the TinyMCE settings array
 * @since 1.0.0
 */
function update_tiny_mce( $init ) {

  $init['block_formats'] = 'Paragraph=p;Heading 2=h2; Heading 3=h3; Heading 4=h4; Blockquote=blockquote';
  return $init;

}

add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\update_tiny_mce' );

/**
 * Remove <p> tags from around images
 * See: http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/
 * @since 1.0.0
 */
function remove_ptags_on_images( $content ) {

  return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );

}

add_filter( 'the_content', __NAMESPACE__ . '\\remove_ptags_on_images' );

/**
 * Remove the injected styles for the [gallery] shortcode
 * @since 1.0.0
 */
function remove_gallery_styles( $css ) {

  return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );

}

add_filter( 'gallery_style', __NAMESPACE__ . '\\remove_gallery_styles' );


/**
* Set Home Page Programmatically if a Page Called "Home" Exists
* @since 1.0.0
*/
function force_homepage() {
  $homepage = get_page_by_title( 'Home' );

  if ( $homepage ) {
      update_option( 'page_on_front', $homepage->ID );
      update_option( 'show_on_front', 'page' );
  }
}

add_action('admin_init', __NAMESPACE__ . '\\force_homepage');


/**
* Removes unnecessary menu items from add new dropdown
* @since 1.0.0
*/
function remove_wp_nodes() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node( 'new-link' );
    $wp_admin_bar->remove_node( 'new-media' );
    $wp_admin_bar->remove_node( 'new-user' );
}

add_action( 'admin_bar_menu', __NAMESPACE__ . '\\remove_wp_nodes', 999 );


/**
 * Filter Yoast SEO Metabox Priority
 * @since 1.0.0
 */
function yoast_seo_metabox_priority() {
  return 'low';
}

add_filter( 'wpseo_metabox_prio', __NAMESPACE__ . '\\yoast_seo_metabox_priority' );


/**
 *  Enable SVG Uploads
 * @since 1.0.0
 */
function enable_svg_uploads($arr = array() ) {
  $arr['svg'] = 'image/svg+xml'; 
  return $arr;
}

add_filter('upload_mimes', __NAMESPACE__ . '\\enable_svg_uploads');



/**
 *  Display SVG Thumbnail
 * @since 1.0.0
 */
function display_svg_thumbnail() {
  echo '<style> svg, img[src*=".svg"] { width: 120px; height: 120px; } </style>';
}

add_action('admin_head', __NAMESPACE__ . '\\display_svg_thumbnail');
