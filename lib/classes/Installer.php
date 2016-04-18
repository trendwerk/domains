<?php
namespace Trendwerk\Domains;

final class Installer
{
    public static function setupSunrise()
    {
        $source = dirname(__DIR__) . '/sunrise.php';
        $destination = WP_CONTENT_DIR . '/sunrise.php';

        copy($source, $destination);
    }
}
