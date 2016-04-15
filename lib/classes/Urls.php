<?php
namespace Trendwerk\Domains;

final class Urls
{
    private $domains = array();

    public function __construct()
    {
        add_filter('pre_option_home', array($this, 'getDomainUrl'));
        add_filter('pre_option_siteurl', array($this, 'getDomainUrl'));
        add_action('template_redirect', array($this, 'redirect'));
    }

    public function getDomainUrl()
    {
        if ($domain = $this->getDomain()) {
            return Helpers\Url::build($domain);
        }

        return false;
    }

    public function redirect()
    {
        global $current_blog;

        $domain = $this->getDomain();

        if ($domain && $domain != $current_blog->domain) {
            $request = str_replace(untrailingslashit($current_blog->path), '', $_SERVER['REQUEST_URI']);
            $url = Helpers\Url::build($domain, $request);

            wp_redirect(trailingslashit($url), 301);
            die();
        }
    }

    private function getDomain()
    {
        $blogId = get_current_blog_id();

        if (isset($this->domains[$blogId])) {
            return $this->domains[$blogId];
        }

        global $wpdb;

        $domain = $wpdb->get_var($wpdb->prepare("SELECT domain FROM {$wpdb->domains} WHERE blog_id = '%s'", $blogId));

        if ($domain) {
            $this->domains[$blogId] = $domain;
        } else {
            $this->domains[$blogId] = false;
        }

        return $this->domains[$blogId];
    }
}
