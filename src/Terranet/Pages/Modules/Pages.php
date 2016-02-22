<?php

namespace Terranet\Pages\Modules;

use App\Page;
use Terranet\Administrator\Contracts\Module\Editable;
use Terranet\Administrator\Contracts\Module\Exportable;
use Terranet\Administrator\Contracts\Module\Filtrable;
use Terranet\Administrator\Contracts\Module\Navigable;
use Terranet\Administrator\Contracts\Module\Sortable;
use Terranet\Administrator\Contracts\Module\Validable;
use Terranet\Administrator\Resource;
use Terranet\Administrator\Traits\Module\AllowFormats;
use Terranet\Administrator\Traits\Module\HasFilters;
use Terranet\Administrator\Traits\Module\HasForm;
use Terranet\Administrator\Traits\Module\HasSortable;
use Terranet\Administrator\Traits\Module\ValidatesForm;

/**
 * Administrator Resource Pages
 *
 * @package Terranet\Administrator
 */
class Pages extends Resource implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats;

    protected $model = Page::class;

    /**
     * Editable form
     *
     * @return array
     */
    public function form()
    {
        return array_merge(
            array_except($this->scaffoldForm(), ['slug']),
            [
                'parent_id' => [
                    'label' => 'Parent',
                    'type' => 'select',
                    'options' => ['' => '--Select--'] + pages_list(),
                ],
                'body' => [
                    'type' => 'tinymce',
                ],
            ]
        );
    }

    /**
     * Columns
     *
     * @return mixed
     */
    public function columns()
    {
        return [
            'id',
            'info' => [
                'elements' => [
                    'title' => ['standalone' => true],
                    'url' => ['output' => function ($row) {
                        return link_to($row->url, $row->title, ['target' => '_blank']);
                    }],
                ],
            ],
            'excerpt',
            'active' => ['output' => function ($row) {
                return \admin\output\boolean($row->active);
            }],
        ];
    }

    /**
     * Validation rules
     *
     * @return mixed
     */
    public function rules()
    {
        return array_except($this->scaffoldRules(), ['slug']);
    }

    public function filters()
    {
        return array_except($this->scaffoldFilters(), ['slug']);
    }
}