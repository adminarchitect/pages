<?php

namespace Terranet\Pages\Models;

use App\Page as LaravelPage;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'body', 'active', 'parent_id'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
        'on_update' => true,
    ];

    protected $appends = [
        'url',
        'excerpt',
    ];

    /**
     * The page url
     *
     * @return mixed null|string
     */
    public function getUrlAttribute()
    {
        return route('pages.show', ['slug' => $this->getSlug()]);
    }

    /**
     * The pages short content
     *
     * @return mixed null|string
     */
    public function getExcerptAttribute()
    {
        if (array_has($this->attributes, 'body')) {
            return str_limit(
                strip_tags($this->attributes['body']),
                200
            );
        }

        return null;
    }

    /**
     * Fetch parent page
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(LaravelPage::class, 'parent_id');
    }

    /**
     * Fetch child pages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(LaravelPage::class, 'parent_id');
    }

    /**
     * Get page siblings
     *
     * @return mixed null|\Illuminate\Database\Eloquent\Collection
     */
    public function siblings()
    {
        if ($p = $this->parent) {
            return $p->children->filter(function ($item) {
                return $item->id !== $this->id;
            });
        }

        return null;
    }
}
