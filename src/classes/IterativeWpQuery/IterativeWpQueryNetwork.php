<?php

namespace Globalis\WP\Cubi;

class IterativeWpQueryNetwork extends IterativeWpQueryAbstract
{
    protected static $queryClassName         = '\\WP_Network_Query';
    protected static $queryArgChunkSize      = 'number';
    protected static $queryHooksTags         = ['pre_get_networks'];
    protected static $queryPropertyResults   = 'networks';
    protected static $queryPropertyFoundRows = 'found_networks';

    const MULTISITE_ONLY = true;
}
