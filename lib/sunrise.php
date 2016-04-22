<?php
use \Trendwerk\Domains\Sunrise;
use \Trendwerk\Domains\Utilities\DotDomains;

if (! defined('WPMU_PLUGIN_DIR')) {
    $pluginDirectory = WP_CONTENT_DIR . '/mu-plugins';
} else {
    $pluginDirectory = WPMU_PLUGIN_DIR;
}

include_once($pluginDirectory . '/domains/lib/autoload.php');

global $wpdb, $current_blog, $blog_id, $current_site;

$dotDomains = new DotDomains();

$sunrise = new Sunrise($wpdb, $dotDomains);

/**
 * Setup WordPress variables
 *
 * @see wp-includes/ms-settings.php
 */
$current_blog = $sunrise->getBlog();

if (! defined('WP_CONTENT_URL')) {
    define('WP_CONTENT_URL', $sunrise->getContentUrl($current_blog));
}

if (! $current_blog) {
    return;
}

$blog_id = $current_blog->blog_id;

$current_site = $sunrise->getSite($current_blog->site_id);
