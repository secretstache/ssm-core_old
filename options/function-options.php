<?php

// Activate Custom Settings
add_action( 'admin_init', 'ssm_core_settings' );

function ssm_core_settings() {
    register_setting( 'ssm-core-settings-group', 'ssm_core_acf_admin_users' );

    register_setting( 'ssm-core-settings-group', 'ssm_core_agency_name' );
    register_setting( 'ssm-core-settings-group', 'ssm_core_agency_url' );

    register_setting( 'ssm-core-settings-group', 'ssm_core_login_logo' );
    register_setting( 'ssm-core-settings-group', 'ssm_core_login_logo_width' );
    register_setting( 'ssm-core-settings-group', 'ssm_core_login_logo_height' );


    add_settings_section( 'ssm-core-agency-options', 'Agency Options', 'ssm_core_agency_options', 'ssm_core');

    add_settings_field( 'ssm-core-agency-name', 'Agency Name', 'ssm_core_agency_name', 'ssm_core', 'ssm-core-agency-options' );
    add_settings_field( 'ssm-core-agency-url', 'Agency URL', 'ssm_core_agency_url', 'ssm_core', 'ssm-core-agency-options' );
    add_settings_field( 'ssm-core-login-logo', 'Login Logo', 'ssm_core_login_logo', 'ssm_core', 'ssm-core-agency-options' );

    add_settings_section( 'ssm-core-acf-options', 'ACF Options', 'ssm_acf_options', 'ssm_core' );

    add_settings_field
    (
        'ssm-core-acf-admin-users',
        'Admin users who need access to ACF',
        'ssm_core_acf_admin_users',
        'ssm_core',
        'ssm-core-acf-options',
        [
            'admins' => get_users( array('role' => 'administrator') )
        ]
    );
}

function ssm_core_agency_options() {

}

function ssm_core_agency_name() {
    $agencyName = get_option('ssm_core_agency_name') != NULL ? esc_attr( get_option('ssm_core_agency_name') ) : 'Secret Stache Media';
    echo '<input type="text" name="ssm_core_agency_name" value="' . $agencyName . '" class="regular-text"/>';
}

function ssm_core_agency_url() {
    $agencyURL = get_option('ssm_core_agency_url') != NULL ? esc_attr( get_option('ssm_core_agency_url') ) : 'http://secretstache.com';
    echo '<input type="text" name="ssm_core_agency_url" value="' . $agencyURL . '" class="regular-text url"/>';
    echo '<p class="description">Include <code>http(s)://</code></p>';
}

function ssm_core_login_logo() {
    $defaultLogo = SSMC_ASSETS_URL . 'images/login-logo.png';
    $loginLogo = get_option('ssm_core_login_logo') != NULL ? esc_attr( get_option('ssm_core_login_logo') ) : $defaultLogo;
    $width = get_option('ssm_core_login_logo_width') != NULL ? esc_attr( get_option('ssm_core_login_logo_width') ) . 'px' : '230px';
    $height = get_option('ssm_core_login_logo_height') != NULL ? esc_attr( get_option('ssm_core_login_logo_height') ) . 'px' : 'auto';

    echo '<div class="login-logo-wrap">';
    echo '<img src="' . $loginLogo . '" id="logo-preview" class="login-logo" alt="Login Logo" style="height: ' . $height . '; width: ' . $width . ';"/>';
    echo '<div class="media-buttons">';
    echo '<input type="button" id="upload-image-button" class="button button-secondary" value="Upload Logo" />';
    echo '<input type="button" id="remove-image-button" class="button button-secondary" value="Remove Logo" />';
    echo '</div>';
    echo '<input type="hidden" id="ssm-core-login-logo" name="ssm_core_login_logo" value="' . $loginLogo . '">';
    echo '<input type="hidden" id="ssm-core-login-logo-width" name="ssm_core_login_logo_width" value="' . $width . '">';
    echo '<input type="hidden" id="ssm-core-login-logo-height" name="ssm_core_login_logo_height" value="' . $height . '">';
    echo '</div>';
}

function ssm_acf_options() {

}

function ssm_core_acf_admin_users( $args ) {
    $admins = $args['admins'];
    $acfAdmins = get_option('ssm_core_acf_admin_users') != NULL ? get_option('ssm_core_acf_admin_users') : array();

    ?>
    <select id="ssm-core-acf-admin-users" name="ssm_core_acf_admin_users[]" multiple style="min-width: 200px;">
        <?php foreach ( $admins as $admin ) { ?>
            <?php $selected = in_array( $admin->ID, $acfAdmins ) ? ' selected' : ''; ?>
            <option value="<?php echo $admin->ID; ?>"<?php echo $selected; ?>>
                <?php echo $admin->user_login; ?>
            </option>
        <?php } ?>
    </select>
    <?php
}


function ssm_core_options_page() {
    require_once( SSMC_OPTIONS_DIR . 'templates/admin-options.php' );
}