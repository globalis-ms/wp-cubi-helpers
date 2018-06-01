<?php

namespace Globalis\WP\Cubi;

class IterativeWpQuerySite extends IterativeWpQueryAbstract
{
    protected static $queryClassName         = '\\WP_Site_Query';
    protected static $queryArgChunkSize      = 'number';
    protected static $queryHooksTags         = ['pre_get_sites'];
    protected static $queryPropertyResults   = 'sites';
    protected static $queryPropertyFoundRows = 'found_sites';

    const MULTISITE_ONLY = true;
}
