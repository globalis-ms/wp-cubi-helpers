<?php

namespace Globalis\WP\Cubi;

abstract class IterativeWpQueryAbstract
{
    protected static $queryClassName;
    protected static $queryArgChunkSize;
    protected static $queryHooksTags;
    protected static $queryPropertyResults;

    protected $args;
    protected $max;

    protected $countRows;
    protected $foundRows;

    protected $results;
    protected $index;

    protected $optionFlushCache;
    protected $optionDisableQueryHooks;

    protected $sizeCacheWpdb;
    protected $sizeCacheObject;

    protected $queryHooks;

    const MULTISITE_ONLY = false;
    
    public function __construct($args, $max = false, $iterationChunkSize = 50)
    {
        if (!is_multisite() && static::MULTISITE_ONLY) {
            throw new \Exception(sprintf('Class %s can not be used outside of a multisite installation.', get_called_class()));
        }

        $this->args                             = $args;
        $this->args['offset']                   = $this->args['offset'] ?? 0;
        $this->args[static::$queryArgChunkSize] = $iterationChunkSize;
        $this->max                              = $max;
        $this->countRows                        = 0;
        $this->index                            = 0;
        $this->optionFlushCache                 = true;
        $this->optionDisableQueryHooks          = true;
    }

    public function setOptionFlushCache($value)
    {
        $this->optionFlushCache = $value;
    }

    public function setOptionDisableQueryHooks($value)
    {
        $this->optionDisableQueryHooks = $value;
    }

    public function getFoundRows()
    {
        if (!isset($this->foundRows)) {
            $this->setFoundRows();
        }
        return $this->foundRows;
    }

    protected function setFoundRows()
    {
        $this->args['no_found_rows'] = false;
        $this->fetchResults();
        $this->args['no_found_rows'] = true;
        if (false !== $this->max && $this->max < $this->foundRows) {
            $this->foundRows = $this->max;
        }
    }

    public function getRow()
    {
        if (!$this->haveRows()) {
            return false;
        }

        if (!isset($this->results[$this->index])) {
            $this->fetchResults();
            $this->index = 0;
            return $this->getRow();
        }

        $this->countRows++;

        return $this->results[$this->index++];
    }

    public function haveRows()
    {
        if (!isset($this->results)) {
            $this->fetchResults();
        }

        if ($this->countRows >= $this->getFoundRows()) {
            $haveRows = false;
        } elseif (false !== $this->max && $this->countRows >= $this->max) {
            $haveRows = false;
        } elseif ($this->index < $this->args[static::$queryArgChunkSize] && count($this->results) < $this->args[static::$queryArgChunkSize]) {
            $haveRows = false;
        } else {
            $haveRows = true;
        }

        if (!$haveRows && $this->optionFlushCache) {
            $this->flush();
        }

        return $haveRows;
    }

    protected function fetchResults()
    {
        $this->beforeQuery();

        $query = new static::$queryClassName($this->args);

        $this->afterQuery($query);

        $this->args['offset'] += $this->args[static::$queryArgChunkSize];

        if (!isset($this->foundRows)) {
            $this->foundRows = $this->queryGetFoundRows($query);
        }

        $this->results = $this->queryGetResults($query);
    }

    protected function beforeQuery()
    {
        if ($this->optionFlushCache) {
            $this->flushCacheObject();
        }

        if ($this->optionFlushCache) {
            $this->saveCacheSizeObject();
            $this->saveCacheSizeWpdb();
        }

        if ($this->optionDisableQueryHooks) {
            $this->disableQueryHooks();
        }
    }

    protected function afterQuery($query)
    {
        if ($this->optionDisableQueryHooks) {
            $this->enableQueryHooks();
        }

        if ($this->optionFlushCache) {
            $this->flushCacheWpdb();
        }
    }

    protected function queryGetFoundRows($query)
    {
        $property = static::$queryPropertyFoundRows;
        return $query->$property;
    }

    protected function queryGetResults($query)
    {
        $property = static::$queryPropertyResults;
        return $query->$property;
    }

    protected function saveCacheSizeObject()
    {
        $this->sizeCacheObject = get_size_cache_object();
    }

    protected function saveCacheSizeWpdb()
    {
        $this->sizeCacheWpdb = get_size_cache_wpdb();
    }

    protected function flushCacheObject()
    {
        if (isset($this->sizeCacheObject)) {
            reset_cache_object($this->sizeCacheObject);
            $this->sizeCacheObject = null;
        }
    }

    protected function flushCacheWpdb()
    {
        if (isset($this->sizeCacheWpdb)) {
            reset_cache_wpdb($this->sizeCacheWpdb);
            $this->sizeCacheWpdb = null;
        }
    }

    protected function flush()
    {
        $this->flushCacheObject();
        $this->flushCacheWpdb();
        $this->results = null;
    }

    protected function disableQueryHooks()
    {
        global $wp_filter;
        foreach (static::$queryHooksTags as $tag) {
            if (isset($wp_filter[$tag])) {
                $this->queryHooks[$tag] = $wp_filter[$tag];
                remove_all_filters($tag);
            }
        }
    }

    protected function enableQueryHooks()
    {
        global $wp_filter;
        foreach (static::$queryHooksTags as $tag) {
            if (isset($this->queryHooks[$tag])) {
                $wp_filter[$tag] = $this->queryHooks[$tag];
                unset($this->queryHooks[$tag]);
            }
        }
    }
}
