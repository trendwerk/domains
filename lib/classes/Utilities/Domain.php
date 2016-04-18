<?php
namespace Trendwerk\Domains\Utilities;

final class Domain
{
    private static $domains;

    /**
     * Retrieve current domain
     */
    public static function get()
    {
        $domains = self::readFile();

        if ($domains && count($domains) > 0) {
            global $current_blog;

            if ($current_blog) {
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

    /**
     * Read domains file and convert to array of domains
     */
    private static function readFile()
    {
        if (isset(self::$domains)) {
            return self::$domains;
        }

        $file = self::determineFile();

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

            self::$domains = $domains;

            return self::$domains;
        }
    }

    /**
     * Determine where domains file is located
     * Searches in WordPress root and two folders up
     */
    private static function determineFile()
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
