<?php

namespace Globalis\WP\Cubi;

class IterativeWpQueryTerm extends IterativeWpQueryAbstract
{
    protected static $queryClassName         = '\\WP_Term_Query';
    protected static $queryArgChunkSize      = 'number';
    protected static $queryHooksTags         = ['pre_get_terms'];
    protected static $queryPropertyResults   = 'terms';
    protected static $queryPropertyFoundRows = false;

    protected function queryGetFoundRows($query)
    {
        $args                           = $this->args;
        $args['fields']                 = 'count';
        $args['offset']                 = 0;
        $args[self::$queryArgChunkSize] = 0;

        $this->beforeQuery();

        $query     = new static::$queryClassName($args);
        $foundRows = $query->get_terms();

        $this->afterQuery($query);

        return $query->get_terms();
    }
}
