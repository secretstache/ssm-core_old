<?php

namespace SSMCore\DashboardWidgets;

add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\\hosting_dashboard_widget' );
/**
 * Add SSM widget to the dashboard.
 */
function hosting_dashboard_widget() {

  wp_add_dashboard_widget(
                 'ssm_main_dashboard_widget', // Widget slug.
                 'Managed Hosting by Secret Stache Media', // Title.
                 __NAMESPACE__ . '\\hosting_widget_function' // Display function.
        );  
}
/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function hosting_widget_function() {

    $html = '<p>As a customer of our managed hosting service, you can rest assured that your software is kept up to date and served on the best hosting technology available.</p>';
    $html .= '<p>You are also covered by our <strong>Code Warantee</strong>, so if you see something that doesn\'t seem right, feel free to <a href="mailto:help@secretstache.com">reach out</a>.';

  echo $html;

}