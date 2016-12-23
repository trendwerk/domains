<?php
namespace Trendwerk\Domains\Utilities;

final class DotDomains implements DomainAdapterInterface
{
    public function __construct()
    {
        if (function_exists('wp_cache_add_global_groups')) {
            wp_cache_add_global_groups('domains');
        }
    }

    public function getCurrentByDomain()
    {
        return $this->getCurrent(function ($carry, $domain) {
            if (in_array($_SERVER['HTTP_HOST'], $domain->domains)) {
                $domain->domain = $_SERVER['HTTP_HOST'];
                unset($domain->domains);

                return $domain;
            }

            return $carry;
        });
    }

    public function getCurrentById()
    {
        return $this->getCurrent(function ($carry, $domain) {
            if ($domain->blogId == get_current_blog_id()) {
                $domain->domain = array_shift($domain->domains);
                unset($domain->domains);

                return $domain;
            }

            return $carry;
        });
    }

    private function getCurrent(callable $filterCallback)
    {
        $domains = $this->readFile();

        if ($domains && count($domains) > 0) {
            return array_reduce($domains, $filterCallback);
        }
    }

    private function readFile()
    {
        if ($domains = wp_cache_get('read', 'domains')) {
            return $this->returnDomains($domains);
        }

        $file = $this->determineFile();

        if ($file) {
            $domains = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            if (count($domains) > 0) {
                $domains = array_map(function ($domain) {
                    $settings = explode('=', $domain);

                    return (object) array(
                        'blogId'  => absint($settings[0]),
                        'domains' => explode(',', $settings[1]),
                    );
                }, $domains);
            }

            wp_cache_set('read', $domains, 'domains');

            return $this->returnDomains($domains);
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

    /**
     * Deep copy domains to stop referencing to object cache
     * See https://core.trac.wordpress.org/ticket/30430
     */
    private function returnDomains($domains)
    {
        return $this->deepCopy($domains);
    }

    private function deepCopy($array)
    {
        $copy = [];

        foreach ($array as $key => $value) {
            $copy[$key] = clone $value;
        }

        return $copy;
    }
}
