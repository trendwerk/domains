<?php
namespace Trendwerk\Domains;

use Trendwerk\Domains\Utilities\DomainAdapterInterface;
use Trendwerk\Domains\Utilities\Url;

final class UrlHandler
{
    private $domainAdapter;

    public function __construct(DomainAdapterInterface $domainAdapter)
    {
        $this->domainAdapter = $domainAdapter;
    }

    public function setup()
    {
        add_filter('pre_option_home', array($this, 'getDomain'));
        add_filter('pre_option_siteurl', array($this, 'getDomain'));
        add_action('admin_init', array($this, 'redirect'));
        add_action('template_redirect', array($this, 'redirect'));
    }

    public function getDomain()
    {
        if ($domain = $this->domainAdapter->getCurrent()) {
            $url = new Url($domain->domain);
            return $url->build($domain->domain);
        }

        return false;
    }

    public function redirect()
    {
        global $current_blog;

        $domain = $this->domainAdapter->getCurrent();

        if ($domain && $domain->domain != $current_blog->domain) {
            $request = str_replace(untrailingslashit($current_blog->path), '', $_SERVER['REQUEST_URI']);
            $url = new Url($domain->domain, $request);

            wp_redirect(trailingslashit($url->build()), 301);
            die();
        }
    }
}
