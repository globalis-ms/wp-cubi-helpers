<?php

namespace Globalis\WP\Cubi;

class IterativeWpQueryPost extends IterativeWpQueryAbstract
{
    protected static $queryClassName         = '\\WP_Query';
    protected static $queryArgChunkSize      = 'posts_per_page';
    protected static $queryHooksTags         = ['pre_get_posts'];
    protected static $queryPropertyResults   = 'posts';
    protected static $queryPropertyFoundRows = 'found_posts';

    public function havePosts()
    {
        return $this->haveRows();
    }

    public function thePost()
    {
        global $post;
        $post = $this->getRow();
        setup_postdata($post);
        return $post;
    }
}
