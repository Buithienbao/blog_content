<?php
/**
 * Nano Core Plugin
 * @package     Nano Core
 * @version     0.1
 * @author      Nanoliberty
 * @link        http://www.nanoliberty.co
 * @copyright   Copyright (c) 2015 Nanoliberty
 * @license     GPL v2
 */

if ( ! defined( 'NANO_VERSION' ) ){
    define('NANO_VERSION', '1.0');
}

if ( ! defined( 'NANO_PLUGIN_PATH' ) ){
    define('NANO_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
}
if ( ! defined( 'NANO_PLUGIN_URL' ) ){
    define('NANO_PLUGIN_URL', plugins_url( '/', __FILE__ ));
}

if ( ! defined( 'NANO_DIRECTORY_NAME' ) ){
    $plugin_path = explode('/', str_replace('\\', '/', NANO_PLUGIN_PATH));
    define('NANO_DIRECTORY_NAME', $plugin_path[count($plugin_path) - 2 ]);
}
if ( ! defined( 'NANO_TEXT_DOMAIN' ) ){
    define('NANO_TEXT_DOMAIN', 'nano');
}
load_plugin_textdomain( 'nano', false, dirname( plugin_basename( __FILE__ ) ));

add_action( 'wp_enqueue_scripts', 'theme_core_script');
function theme_core_script()
{
    wp_enqueue_style('core-front', NANO_PLUGIN_URL . 'assets/css/na-core-front.css', array(), NANO_VERSION);
    wp_enqueue_script('isotope', NANO_PLUGIN_URL . 'assets/js/isotope.pkgd.min.js', array('jquery'), '2.2.0', true);
    wp_enqueue_script('infinitescroll', NANO_PLUGIN_URL . 'assets/js/jquery.infinitescroll.js', array('jquery'),'2.1.0', true);
    wp_enqueue_script('core-front', NANO_PLUGIN_URL . 'assets/js/dev/na-core-front.js', array('jquery'), NANO_VERSION, true);
    // Load ajax object
    $translation_array = array(
        'home_url' => esc_url( home_url( '/' ) ),
        'ajax_url' => wp_nonce_url(admin_url('admin-ajax.php')),
        'admin_theme_url' => wp_nonce_url(admin_url('themes.php'))
    );
    wp_localize_script( 'core-front', 'NaScript', $translation_array );
}

add_action('admin_init', 'core_admin_scripts');
function core_admin_scripts() {
    wp_enqueue_style('core-admin', NANO_PLUGIN_URL . 'assets/css/na-core-admin.css', array(), NANO_VERSION);
    wp_enqueue_script('core-admin', NANO_PLUGIN_URL . 'assets/js/dev/na-core-admin.js', array('jquery'), NANO_VERSION, true);
}

