<?php

namespace Globalis\WP\Cubi;

class IterativeWpQueryComment extends IterativeWpQueryAbstract
{
    protected static $queryClassName         = '\\WP_Comment_Query';
    protected static $queryArgChunkSize      = 'number';
    protected static $queryHooksTags         = ['pre_get_comments'];
    protected static $queryPropertyResults   = 'comments';
    protected static $queryPropertyFoundRows = 'found_comments';
}
