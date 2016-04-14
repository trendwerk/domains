<?php
namespace Trendwerk\Domains;

final class Installer
{
    public static function createTable()
    {
        global $wpdb;

        include_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta("CREATE TABLE {$wpdb->domains} (
            id bigint(20) NOT NULL auto_increment,
            blog_id bigint(20) NOT NULL,
            domain varchar(255) NOT NULL,
            PRIMARY KEY  (id)
        ) {$wpdb->get_charset_collate()};");
    }

    public static function setupSunrise()
    {
        $source = dirname(__DIR__) . '/sunrise.php';
        $destination = WP_CONTENT_DIR . '/sunrise.php';

        copy($source, $destination);
    }
}
