<?php
namespace ScientiaMobile\WurflCloud\Cache;

class MemcachedTest extends CacheTestCase {

    public function setUp() {
        if (!extension_loaded('memcached')) {
            $this->markTestSkipped("PHP extension 'memcached' is not loaded");
        }

        if (version_compare(PHP_VERSION, '7.0.0', '>=')) {
            // @see https://github.com/php-memcached-dev/php-memcached/issues/213
            $this->markTestSkipped("No stable memcached extension for PHP >= 7.0.0 yet");
        }

        $host = '127.0.0.1';
        $port = 11211;

        $this->cache = new Memcached();
        $this->cache->addServer($host, $port);

        $memcache = $this->cache->getMemcache();
        $version = $memcache->getVersion();
        $server_version = $version["{$host}:{$port}"];

        if ($server_version == '255.255.255') {
            $this->markTestSkipped("Cannot connect to local memcached server");
        }
    }
}
