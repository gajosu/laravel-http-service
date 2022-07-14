<?php

namespace Gajosu\LaravelHttpClient\Traits;

use DateTime;
use Gajosu\LaravelHttpClient\Builders\ApiResponse;
use Illuminate\Contracts\Cache\Repository;

trait RequestCacheModule
{
    /**
     * The number of seconds or the DateTime instance
     * that specifies how long to cache the query.
     *
     * @var DateTime|int|null
     */
    protected DateTime|int|null $cache_ttl = null;

    /**
     * Set if the caching should be avoided.
     *
     * @var bool
     */
    protected $avoidCache = false;

    /**
     * Set prefix for the cache key.
     *
     * @var string
     */
    protected string $cache_prefix = 'http_request';

    /**
     * Indicate that the response should be cached
     *
     * @param DateTime|int|null $seconds
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function cacheFor(DateTime|int|null $seconds): self
    {
        $this->cache_ttl = $seconds;

        return $this;
    }

    /**
     * Indicate that the response should be cached forever
     *
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function cacheForever(): self
    {
        return $this->cacheFor(-1);
    }

    /**
     * Check if the cache operation should be avoided.
     *
     * @return bool
     */
    public function shouldAvoidCache(): bool
    {
        return $this->avoidCache;
    }

    /**
     * Indicate that the query should not be cached.
     *
     * @param  bool  $avoidCache
     * @return \Gajosu\LaravelHttpClient\Builders\ApiRequestBuilder
     */
    public function dontCache(bool $avoidCache = true): self
    {
        $this->avoidCache = $avoidCache;

        return $this;
    }

    /**
     * Get the cache key.
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return $this->cache_prefix . '_' . md5(serialize([
            'method' => $this->method,
            'url' => $this->base_uri . $this->path,
            'query' => $this->query,
            'body' => $this->body,
            'multipart' => $this->multipart,
        ]));
    }

    /**
     * Get the cache TTL.
     *
     * @return int
     */
    public function getCacheTtl(): int
    {
        if ($this->cache_ttl instanceof DateTime) {
            return $this->cache_ttl->getTimestamp() - time();
        }

        return $this->cache_ttl;
    }

    /**
     * Save the response in the cache.
     *
     * @param string $key
     * @param \Gajosu\LaravelHttpClient\Builders\ApiResponse $response
     * @return void
     */
    protected function saveResponseToCache(string $key, ApiResponse $response): void
    {
        $ttl = $this->getCacheTtl();
        $cache = $this->getCacheDriver();
        if ($ttl > 0) {
            $cache->put($key, $response, $ttl);
        } else {
            $cache->forever($key, $response);
        }
    }

    /**
     * Get the response from the cache.
     *
     * @param string $key
     * @return \Gajosu\LaravelHttpClient\Builders\ApiResponse
     */
    protected function getResponseFromCache(string $key): ApiResponse|null
    {
        return $this->getCacheDriver()->get($key);
    }

    /**
     * Get the cache driver.
     *
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function getCacheDriver(): Repository
    {
        return app('cache')->driver();
    }
}
