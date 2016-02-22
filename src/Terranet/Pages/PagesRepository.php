<?php

namespace Terranet\Pages;

use Terranet\Pages\Contracts\PagesRepository as PagesContract;

class PagesRepository implements PagesContract
{
    protected $model;

    protected $with = ['parent'];

    public function __construct($model)
    {
        $this->model = $this->createModel($model);
    }

    /**
     * Create model
     *
     * @param $class
     * @return mixed
     */
    protected function createModel($class)
    {
        if (is_string($class))
            $class = (new $class);

        return $class;
    }

    /**
     * Load page relations
     *
     * @param mixed array|string $relations
     * @return $this
     */
    public function with($relations = [])
    {
        if (! is_array($relations)) {
            $relations = [$relations];
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Find news by unique identifier
     *
     * @param $slug
     * @return \App\Page
     */
    public function findBySlug($slug)
    {
        return $this->model
            ->whereSlug($slug)
            ->with($this->with)
            ->first();
    }

    /**
     * Fetch pages tree
     *
     * @return array
     */
    public function tree()
    {
        $items = $this->model
            ->orderBy('id')
            ->orderBy('parent_id')
            ->with($this->with)
            ->get()
            ->toArray();

        return $this->toTree($items);
    }

    /**
     * Transform dataSet to a tree
     *
     * @param array $dataSet
     * @return array
     */
    protected function toTree(array $dataSet = [])
    {
        $tree = [];

        /*
         * Most dataSets in the wild are enumerative arrays and we need associative array
         * where the same ID used for addressing parents is used. We make associative
         * array on the fly
        */
        $references = [];

        foreach ($dataSet as $id => &$node) {
            // Add the node to our associative array using it's ID as key
            $references[$node['id']] = &$node;

            // Add empty placeholder for children
            $node['children'] = [];

            // It it's a root node, we add it directly to the tree
            if (is_null($node['parent_id'])) {
                $tree[$node['id']] = &$node;
            } else {
                // It was not a root node, add this node as a reference in the parent.
                $references[$node['parent_id']]['children'][$node['id']] = &$node;
            }
        }

        return $tree;
    }

    /**
     * Fetch pages tree as list
     *
     * @return array
     */
    public function lists()
    {
        return $this->toList(
            $this->with([])->tree()
        );
    }

    /**
     * Transform tree to list
     *
     * @param $items
     * @param int $level
     * @return array
     */
    protected function toList(array $items = [], $level = 0)
    {
        $prefix = str_repeat('&nbsp;&nbsp;', $level);

        $pages = [];

        foreach ($items as $item) {
            $pages[$item['id']] = $prefix . '' . $item['title'];

            if ($item['children']) {
                $pages += $this->toList($item['children'], $level + 1);
            }
        }

        return $pages;
    }
}
