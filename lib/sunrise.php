<?php
use Trendwerk\Domains\Sunrise;

if (! defined('WPMU_PLUGIN_DIR')) {
    $pluginDirectory = WP_CONTENT_DIR . '/mu-plugins';
} else {
    $pluginDirectory = WPMU_PLUGIN_DIR;
}

include_once($pluginDirectory . '/domains/lib/autoload.php');

$sunrise = new Sunrise();

/**
 * Setup WordPress variables
 *
 * @see wp-includes/ms-settings.php
 */
$current_blog = $sunrise->getBlog();

if (! $current_blog) {
    return;
}

$blog_id = $current_blog->blog_id;

$current_site = $sunrise->getSite($current_blog->site_id);
