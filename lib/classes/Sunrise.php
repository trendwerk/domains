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

    public function getSite($siteId, $blogId)
    {
        $site = \WP_Network::get_instance($siteId);
        $site->blog_id = absint($blogId);

        return $site;
    }
}
