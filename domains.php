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
 * Version: 0.1.0
 */

namespace Trendwerk\Domains;

include_once('lib/autoload.php');

register_activation_hook(__FILE__, array('\Trendwerk\Domains\Installer', 'createTable'));
register_activation_hook(__FILE__, array('\Trendwerk\Domains\Installer', 'setupSunrise'));
