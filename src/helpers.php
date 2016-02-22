<?php

use Terranet\Pages\Contracts\PagesRepository as PagesContract;

if (! function_exists("pages")) {
    /**
     * Pages repository
     *
     * @return PagesContract
     */
    function pages()
    {
        return app(PagesContract::class);
    }
}

if (! function_exists('pages_tree')) {
    /**
     * Fetch pages tree
     *
     * @return array
     */
    function pages_tree()
    {
        return pages()->tree();
    }
}

if (! function_exists('pages_list')) {
    /**
     * Fetch pages tree as a list
     *
     * @return array
     */
    function pages_list()
    {
        return pages()->lists();
    }
}