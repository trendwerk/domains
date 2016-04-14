<?php
namespace Trendwerk\Domains;

final class Plugin
{
    private static $table = 'domains';

    public function __construct()
    {
        self::setupTable();
    }

    public static function setupTable()
    {
        global $wpdb;

        $wpdb->domains = $wpdb->prefix . self::$table;
    }
}
