<?php
if (! defined('WPMU_PLUGIN_DIR')) {
    $pluginDirectory = WP_CONTENT_DIR . '/mu-plugins';
} else {
    $pluginDirectory = WPMU_PLUGIN_DIR;
}

include_once($pluginDirectory . '/domains/lib/autoload.php');
