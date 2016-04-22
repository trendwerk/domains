<?php
namespace Trendwerk\Domains\Utilities;

final class DotDomains implements DomainAdapterInterface
{
    private $currentBlog;

    public function __construct(\WP_Site $currentBlog = null)
    {
        $this->currentBlog = $currentBlog;
    }

    public function getCurrent()
    {
        $domains = $this->readFile();

        if ($domains && count($domains) > 0) {
            if ($this->currentBlog) {
                // Sunrise has booted, determine by blog ID
                foreach ($domains as $domain) {
                    if ($domain->blogId == get_current_blog_id()) {
                        return $domain;
                    }
                }
            } else {
                // Determine by domain
                foreach ($domains as $domain) {
                    if ($domain->domain == $_SERVER['HTTP_HOST']) {
                        return $domain;
                    }
                }
            }
        }
    }

    private function readFile()
    {
        $file = $this->determineFile();

        if ($file) {
            $domains = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (count($domains) > 0) {
                $domains = array_map(function ($domain) {
                    $settings = explode('=', $domain);

                    return (object) array(
                        'blogId' => absint($settings[0]),
                        'domain' => $settings[1],
                    );
                }, $domains);
            }

            return $domains;
        }
    }

    private function determineFile()
    {
        $file = '/.domains';

        $folder = substr(ABSPATH, 0, strlen(ABSPATH) - 1);
        $depth = 0;

        do {
            if (file_exists($folder . $file)) {
                return $folder . $file;
            } else {
                $folder = dirname($folder);
            }

            $depth++;
        } while ($depth <= 2);
    }
}
