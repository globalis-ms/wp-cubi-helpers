<?php

namespace Globalis\WP\Cubi;

class IterativeWpQueryUser extends IterativeWpQueryAbstract
{
    protected static $queryClassName         = '\\WP_User_Query';
    protected static $queryArgChunkSize      = 'number';
    protected static $queryHooksTags         = ['pre_get_users'];
    protected static $queryPropertyResults   = 'results';
    protected static $queryPropertyFoundRows = 'total_users';
}
