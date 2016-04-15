<?php
namespace Trendwerk\Domains\Helpers;

final class Url
{
    public static function build($domain, $request = '')
    {
        return self::getProtocol() . $domain . $request;
    }

    public static function getProtocol()
    {
        return is_ssl() ? 'https://' : 'http://';
    }
}
