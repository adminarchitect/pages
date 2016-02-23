<?php

namespace Terranet\Pages\Contracts;

use App\Page;

interface PagesRepository
{
    /**
     * Find news by unique identifier
     *
     * @param string $slug
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

    /**
     * Get page siblings
     *
     * @param Page $page
     * @return mixed null|\Illuminate\Database\Eloquent\Collection
     */
    public function siblings(Page $page);
}