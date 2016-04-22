<?php
use Trendwerk\Domains\UrlHandler;
use Trendwerk\Domains\Utilities\DotDomains;

add_action('muplugins_loaded', function () {
    $dotDomains = new DotDomains();

    $urlReplacer = new UrlHandler($dotDomains);
    $urlReplacer->setup();
}, 0);
