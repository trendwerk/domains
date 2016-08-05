<?php
/**
 * Plugin Name: Domains
 * Description: Domains for WordPress Multisite.
 *
 * Plugin URI: https://github.com/trendwerk/domains
 *
 * Author: Trendwerk
 * Author URI: https://github.com/trendwerk
 *
 * Version: 0.1.1
 */

include_once('lib/autoload.php');
include_once('lib/init.php');

register_activation_hook(__FILE__, array('\Trendwerk\Domains\Installer', 'setupSunrise'));
