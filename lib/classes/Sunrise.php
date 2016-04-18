<?php
namespace Trendwerk\Domains;

final class Sunrise
{
    public function getBlog()
    {
        global $wpdb;

        $domain = Utilities\Domain::get();

        if (! $domain) {
            return;
        }

        $blog = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->blogs} WHERE blog_id = '%s'", $domain->blogId));

        if (! $blog) {
            return;
        }

        $blog->domain = $domain->domain;
        $blog->path = '/';

        return $blog;
    }

    public function getSite($siteId)
    {
        global $wpdb;

        $site = \WP_Network::get_instance($siteId);
        $site->blog_id = $wpdb->get_var($wpdb->prepare("SELECT blog_id FROM {$wpdb->blogs} WHERE domain = '%s' AND path = '%s'", $site->domain, $site->path));

        return $site;
    }

    public function getContentUrl($blog)
    {
        if (! $blog) {
            $domain = DOMAIN_CURRENT_SITE;
        } else {
            $domain = $blog->domain;
        }

        if (defined('CONTENT_DIR')) {
            $contentDir = CONTENT_DIR;
        } else {
            $contentDir = '/wp-content';
        }

        return Utilities\Url::build($domain, $contentDir);
    }
}
