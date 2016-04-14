<?php
namespace Trendwerk\Domains;

final class Urls
{
    public function __construct()
    {
        add_action('template_redirect', array($this, 'redirect'));
    }

    public function redirect()
    {
        global $current_blog;
        $domain = $this->getDomain();

        if ($domain && $domain != $current_blog->domain) {
            global $wp;

            $url = trailingslashit($this->getProtocol() . trailingslashit($domain) . $wp->request);

            wp_redirect($url, 301);
            die();
        }
    }

    private function getDomain()
    {
        global $wpdb;

        return $wpdb->get_var($wpdb->prepare("SELECT domain FROM {$wpdb->domains} WHERE blog_id = '%s'", get_current_blog_id()));
    }

    private function getProtocol()
    {
        return is_ssl() ? 'https://' : 'http://';
    }
}
