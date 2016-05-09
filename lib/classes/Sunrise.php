<?php
namespace Trendwerk\Domains;

use Trendwerk\Domains\Utilities\DomainAdapterInterface;
use Trendwerk\Domains\Utilities\Url;

final class Sunrise
{
    private $domainAdapter;
    private $wpdb;

    public function __construct(\wpdb $wpdb, DomainAdapterInterface $domainAdapter)
    {
        $this->domainAdapter = $domainAdapter;
        $this->wpdb = $wpdb;
    }

    public function getBlog()
    {
        $domain = $this->domainAdapter->getCurrent();

        if (! $domain) {
            return;
        }

        $blog = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->wpdb->blogs} WHERE blog_id = '%s'", $domain->blogId));

        if (! $blog) {
            return;
        }

        $blog->domain = $domain->domain;
        $blog->path = '/';

        return $blog;
    }

    public function getSite($siteId)
    {
        $site = \WP_Network::get_instance($siteId);
        $site->blog_id = $this->wpdb->get_var($this->wpdb->prepare("SELECT blog_id FROM {$this->wpdb->blogs} WHERE domain = '%s' AND path = '%s'", $site->domain, $site->path));

        return $site;
    }

    public function getContentUrl(\stdClass $blog = null)
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

        $url = new Url($domain, $contentDir);

        return $url->build();
    }
}
