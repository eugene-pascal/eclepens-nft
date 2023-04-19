<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model implements HasMedia
{
    use InteractsWithMedia;

    const _MEDIA_COLLECTION_NAME = 'article';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'code_lang2',
        'code_unique',
        'code_name',
        'title',
        'text',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'display',
        'published_at'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'display' => 'boolean',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb300x300')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

}
