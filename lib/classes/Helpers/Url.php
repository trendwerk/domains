<?php
namespace Trendwerk\Domains\Helpers;

final class Url
{
    public static function build($domain, $request = '')
    {
        return self::getProtocol() . $domain . $request;
    }

    private static function getProtocol()
    {
        return is_ssl() ? 'https://' : 'http://';
    }
}
