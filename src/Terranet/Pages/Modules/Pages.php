<?php

namespace Terranet\Pages\Modules;

use App\Page;
use Terranet\Administrator\Columns\Element;
use Terranet\Administrator\Contracts\Module\Editable;
use Terranet\Administrator\Contracts\Module\Exportable;
use Terranet\Administrator\Contracts\Module\Filtrable;
use Terranet\Administrator\Contracts\Module\Navigable;
use Terranet\Administrator\Contracts\Module\Sortable;
use Terranet\Administrator\Contracts\Module\Validable;
use Terranet\Administrator\Form\Collection\Mutable;
use Terranet\Administrator\Form\FormElement;
use Terranet\Administrator\Form\Type\Select;
use Terranet\Administrator\Scaffolding;
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
class Pages extends Scaffolding implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats;

    protected $model = Page::class;

    protected function inputTypes()
    {
        return [
            'body' => 'tinymce',
        ];
    }

    /**
     * Editable form
     *
     * @return Mutable
     */
    public function form()
    {
        return $this->scaffoldForm()
                    ->without(['slug'])
                    ->update('parent_id', function (FormElement $element) {
                        $control = new Select('parent_id');
                        $control->setOptions(['' => '--Select--'] + pages()->lists());

                        return $element->setInput($control);
                    });
    }

    /**
     * Columns
     *
     * @return mixed
     */
    public function columns()
    {
        return $this->scaffoldColumns()
                    ->without(['slug'])
                    ->update('title', function (Element $title) {
                        return $title->setStandalone(true);
                    })
                    ->push('url')
                    ->join(['title', 'url'], 'info', 1);
    }

    /**
     * Validation rules
     *
     * @return mixed
     */
    public function rules()
    {
        return array_except($this->scaffoldRules(), ['slug', 'parent_id']);
    }

    public function filters()
    {
        return $this->scaffoldFilters()->without(['slug'])->move('title', 0);
    }
}
