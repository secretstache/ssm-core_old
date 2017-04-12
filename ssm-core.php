<?php

/**
 * The plugin bootstrap file
 *
 * @link              http://secretstache.com
 * @since             0.1.0
 * @package           SSM_Core
 *
 * @wordpress-plugin
 * Plugin Name:       SSM Core
 * Plugin URI:        http://secretstache.com
 * Description:       A collection of very opinionated modules that set up SSM projects.
 * Version:           1.0.0
 * Author:            Secret Stache Media
 * Author URI:        http://secretstache.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ssm-core
 * Domain Path:       /languages
 */

namespace SSMCore;

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Defining some Constants
 */
define( 'SSMC_VERSION', '0.1.0' );
define( 'SSMC_URL', trailingslashit ( plugin_dir_url( __FILE__ ) ) );
define( 'SSMC_DIR', plugin_dir_path( __FILE__ ) );
define( 'SSMC_MODULES_DIR', trailingslashit( SSMC_DIR . 'modules' ) );
define( 'SSMC_OPTIONS_DIR', trailingslashit( SSMC_DIR . 'options' ) );
define( 'SSMC_ASSETS_URL', trailingslashit ( plugin_dir_url( __FILE__ ) . 'assets' ) );

/**
 * Require Files
 */
require SSMC_OPTIONS_DIR . 'function-options.php';
require SSMC_DIR . 'lib/plugin_update_check.php';

function load_admin_scripts( $hook ) {

    if ( $hook != 'settings_page_ssm_core' )
        return;

    wp_register_style( 'ssm-core-admin-css', SSMC_ASSETS_URL . 'styles/admin.css', array(), SSMC_VERSION , 'all' );
    wp_enqueue_style( 'ssm-core-admin-css' );

    wp_enqueue_media();

    wp_register_script( 'ssm-core-admin-js', SSMC_ASSETS_URL . 'scripts/admin.js', array('jquery'), SSMC_VERSION, true );

    $login_logo_array = array(
        'url' => SSMC_ASSETS_URL . 'images/login-logo.png',
    );

    wp_localize_script( 'ssm-core-admin-js', 'login_logo', $login_logo_array );

    wp_enqueue_script( 'ssm-core-admin-js' );

}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\load_admin_scripts' );


class ModuleOptions {
  protected static $modules = [];
  protected $options = [];

  public static function init($module, $options = []) {
    if (!isset(self::$modules[$module])) {
      self::$modules[$module] = new static((array) $options);
    }
    return self::$modules[$module];
  }

  // public static function getByFile($file) {
  //   if (file_exists($file) || file_exists(__DIR__ . '/modules/' . $file)) {
  //     return self::get('ssm-' . basename($file, '.php'));
  //   }
  //   return [];
  // }

  // public static function get($module) {
  //   if (isset(self::$modules[$module])) {
  //     return self::$modules[$module]->options;
  //   }
  //   if (substr($module, 0, 5) !== 'ssm-') {
  //     return self::get('ssm-' . $module);
  //   }
  //   return [];
  // }

  // protected function __construct($options) {
  //   $this->set($options);
  // }

  // public function set($options) {
  //   $this->options = $options;
  // }
}


function load_modules() {
  global $_wp_theme_features;
  foreach (glob(SSMC_DIR . '/modules/*.php') as $file) {
    $feature = 'ssm-' . basename($file, '.php');
    if (isset($_wp_theme_features[$feature])) {
      ModuleOptions::init($feature, $_wp_theme_features[$feature]);
      require_once $file;
    }
  }
}

add_action('after_setup_theme', __NAMESPACE__ . '\\load_modules', 100);

// Get prb option value
function get_option( $option_name, $default = '' ) {

    if ( \get_option('ssm_core_options')[$option_name] != NULL ) {
      return \get_option('ssm_core_options')[$option_name];
    } else {
      return $default;
    }
}

function add_options_page() {

    if ( ! current_theme_supports('ssm-admin-branding') && ! current_theme_supports('ssm-admin-branding') )
      return;

    add_submenu_page(
    'options-general.php',
      'SSM Core', // page title
      'Core', // menu title
    'manage_options',
    'ssm_core',
    'ssm_core_options_page'
  );

}
add_action('admin_menu', __NAMESPACE__ . '\\add_options_page', 99);

// Kernl Support
$MyUpdateChecker = new \PluginUpdateChecker_2_0 (
    'https://kernl.us/api/v1/updates/57ab49c47f334ccf27b16476/',
    __FILE__,
    'ssm-core',
    1
);