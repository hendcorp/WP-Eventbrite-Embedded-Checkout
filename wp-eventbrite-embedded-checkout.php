<?php
/**
 * Plugin Name: WP Eventbrite Embedded Checkout
 * Plugin URI: https://hellohendra.com
 * Description: Allows people to buy Eventbrite tickets without leaving your website. Sell tickets right from your WordPress site!
 * Author: Hendra Setiawan
 * Version: 1.0.0
 * Text Domain: hellohendra
 * Written by: Hendra Setiawan - https://hellohendra.com
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

define("WPEEC_PLUGIN_PATH", plugin_dir_path(__FILE__));

// Admin Functions
require_once( WPEEC_PLUGIN_PATH . 'admin/admin-functions.php' );

// Embed Functions
require_once( WPEEC_PLUGIN_PATH . 'lib/embed-functions.php' );