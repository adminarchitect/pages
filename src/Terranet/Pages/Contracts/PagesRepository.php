<?php

namespace Terranet\Pages\Contracts;

interface PagesRepository
{
    /**
     * Find news by unique identifier
     *
     * @param $slug
     * @return \App\Page
     */
    public function findBySlug($slug);

    /**
     * Build pages tree
     *
     * @return array
     */
    public function tree();

    /**
     * Fetch pages tree as list
     *
     * @return array
     */
    public function lists();
}