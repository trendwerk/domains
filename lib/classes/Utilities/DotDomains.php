<?php
namespace Trendwerk\Domains\Utilities;

final class DotDomains implements DomainAdapterInterface
{
    public function getCurrentByDomain()
    {
        return $this->getCurrent(function ($carry, $domain) {
            if ($domain->domain == $_SERVER['HTTP_HOST']) {
                return $domain;
            }

            return $carry;
        });
    }

    public function getCurrentById()
    {
        return $this->getCurrent(function ($carry, $domain) {
            if ($domain->blogId == get_current_blog_id()) {
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
