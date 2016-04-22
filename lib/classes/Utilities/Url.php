<?php
namespace Trendwerk\Domains\Utilities;

final class Url
{
    private $domain;
    private $request;

    public function __construct($domain, $request = '')
    {
        $this->domain = $domain;
        $this->request = $request;
    }

    public function build()
    {
        return $this->getProtocol() . $this->domain . $this->request;
    }

    private function getProtocol()
    {
        return is_ssl() ? 'https://' : 'http://';
    }
}
