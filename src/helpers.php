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
