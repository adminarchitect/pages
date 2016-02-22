<?php

namespace Terranet\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Show news item
     *
     * @param $slug
     * @return mixed
     */
    public function show($slug)
    {
        return pages()->with(['children', 'parent'])->findBySlug($slug);
    }
}