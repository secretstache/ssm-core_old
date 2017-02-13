<?php

namespace SSMCore\AdminBranding;

add_filter( 'login_headerurl', __NAMESPACE__ . '\\login_headerurl' );
/**
 * Makes the login screen's logo link to your homepage, instead of to WordPress.org.
 * @since 1.0.0
 */
function login_headerurl() {
    return home_url();
}

add_filter( 'login_headertitle', __NAMESPACE__ . '\\login_headertitle' );
/**
 * Makes the login screen's logo title attribute your site title, instead of 'WordPress'.
 * @since 1.0.0
 */
function login_headertitle() {
    return get_bloginfo( 'name' );
}



add_action( 'login_enqueue_scripts', __NAMESPACE__ . '\\login_logo' );
/**
 * Replaces the login screen's WordPress logo with the 'login-logo.png' in your child theme images folder.
 * Disabled by default. Make sure you have a login logo before using this function!
 * Updated 2.0.1: Assumes SVG logo by default
 * @since 1.0.0
 */
function login_logo() {

$defaultLogo = SSMC_ASSETS_URL . 'images/login-logo.png';

$background_image =  get_option('ssm_core_login_logo') != NULL ? get_option('ssm_core_login_logo') : $defaultLogo;
$height =  get_option('ssm_core_login_logo_height') != NULL ? get_option('ssm_core_login_logo_height') : '128';
$width =  get_option('ssm_core_login_logo_width') != NULL ? get_option('ssm_core_login_logo_width') : '150';

    ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo $background_image; ?>) !important;
            background-repeat: no-repeat;
            background-size: cover;
            height: <?php echo $height; ?>px;
            margin-bottom: 15px;
            width: <?php echo $width; ?>px;
        }
    </style>
    <?php

}

add_filter( 'wp_mail_from_name', __NAMESPACE__ . '\\mail_from_name' );
/**
 * Makes WordPress-generated emails appear 'from' your WordPress site name, instead of from 'WordPress'.
 * @since 1.0.0
 */
function mail_from_name() {
    return get_option( 'blogname' );
}

add_filter( 'wp_mail_from', __NAMESPACE__ . '\\wp_mail_from' );
/**
 * Makes WordPress-generated emails appear 'from' your WordPress admin email address.
 * Disabled by default, in case you don't want to reveal your admin email.
 * @since 1.0.0
 */
function wp_mail_from() {
    return get_option( 'admin_email' );
}

add_action( 'wp_before_admin_bar_render', __NAMESPACE__ . '\\remove_wp_icon_from_admin_bar' );
/**
 * Removes the WP icon from the admin bar
 * See: http://wp-snippets.com/remove-wordpress-logo-admin-bar/
 * @since 1.0.0
 */
function remove_wp_icon_from_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wp-logo');
}

add_filter( 'admin_footer_text', __NAMESPACE__ . '\\admin_footer_text' );
/**
 * Modify the admin footer text
 * See: http://wp-snippets.com/change-footer-text-in-wp-admin/
 * @since 1.0.0
 */
function admin_footer_text () {

    $footer_text = get_option('ssm_core_agency_name') != NULL ? get_option('ssm_core_agency_name') : 'Secret Stache Media';
    $footer_link = get_option('ssm_core_agency_url') != NULL ? get_option('ssm_core_agency_url') : 'http://secretstache.com';

    echo 'Built by <a href="' . $footer_link . '" target="_blank">' . $footer_text . '</a> with WordPress.';
}