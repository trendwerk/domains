<?php
namespace Trendwerk\Domains;

final class Urls
{
    private $domains = array();

    public function __construct()
    {
        add_filter('pre_option_home', array($this, 'getDomainUrl'));
        add_filter('pre_option_siteurl', array($this, 'getDomainUrl'));
        add_action('admin_init', array($this, 'redirect'));
        add_action('template_redirect', array($this, 'redirect'));
    }

    public function getDomainUrl()
    {
        if ($domain = Utilities\Domain::get()) {
            return Utilities\Url::build($domain->domain);
        }

        return false;
    }

    public function redirect()
    {
        global $current_blog;

        $domain = Utilities\Domain::get();

        if ($domain && $domain->domain != $current_blog->domain) {
            $request = str_replace(untrailingslashit($current_blog->path), '', $_SERVER['REQUEST_URI']);
            $url = Utilities\Url::build($domain->domain, $request);

            wp_redirect(trailingslashit($url), 301);
            die();
        }
    }
}
