<?php
namespace Trendwerk\Domains;

final class Sunrise
{
    public static function add()
    {
        $source = dirname(__DIR__) . '/sunrise.php';
        $destination = WP_CONTENT_DIR . '/sunrise.php';

        copy($source, $destination);
    }
}
