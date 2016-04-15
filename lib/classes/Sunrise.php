<?php
namespace Trendwerk\Domains;

final class Sunrise
{
    public function getBlog()
    {
        global $wpdb;
        Plugin::setupTable();

        $domain = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->domains} WHERE domain = '%s'", $_SERVER['HTTP_HOST']));

        if (! $domain) {
            return;
        }

        $blog = $wpdb->get_row("SELECT * FROM {$wpdb->blogs} WHERE blog_id = '{$domain->blog_id}'");

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
        $site->blog_id = $wpdb->get_var("SELECT blog_id FROM {$wpdb->blogs} WHERE domain = '{$site->domain}' AND path = '{$site->path}'");

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

        return Helpers\Url::build($domain, $contentDir);
    }
}
