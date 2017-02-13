<?php 

namespace SSMCore\ACF;

/**
 * Hide Advanced Custom Fields to Users
 * @since 1.0.0
 */
function remove_acf_menu() {

  // provide a list of usernames who can edit custom field definitions here
  $acfAdmins = get_option('ssm_core_acf_admin_users') != NULL ? get_option('ssm_core_acf_admin_users') : array(1);

  // get the current user
  $current_user = wp_get_current_user();

  if ( $acfAdmins != NULL ) {

    // match and remove if needed
    if( !in_array( $current_user->ID, $acfAdmins ) ) {
        remove_menu_page('edit.php?post_type=acf-field-group');
    }

  }
}

add_action('admin_init', __NAMESPACE__ . '\\remove_acf_menu');
