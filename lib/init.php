<?php
use Trendwerk\Domains\UrlHandler;
use Trendwerk\Domains\Utilities\DotDomains;

add_action('muplugins_loaded', function () {
    global $current_blog;

    $dotDomains = new DotDomains();

    $urlReplacer = new UrlHandler($dotDomains, $current_blog);
    $urlReplacer->setup();
}, 0);
