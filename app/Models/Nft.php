<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Nft extends Model implements HasMedia
{
    use InteractsWithMedia;

    const _MEDIA_COLLECTION_NAME = 'nft';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'standard',
        'author',
        'name',
        'descr',
        'display',
        'published_at',
        'max_nft'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'display' => 'boolean',
    ];

    /**
     * @param Media|null $media
     * @return void
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb300x300')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    /**
     * Get all tags for the NFT
     *
     * @return MorphToMany
     */
    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable', 'terms_taggable',null,'term_id');
    }

    /**
     * Get all tags into one string to be seperated with $separator
     *
     * @param string $separator
     * @return string
     */
    public function allTagsIntoStr(string $separator = ','): string
    {
        $arr = $this->tags()->pluck('name')->all();
        return implode($separator, $arr);
    }

    /**
     * @return void
     */
    public function deleteWithRelations(): void {
        $this->tags()->detach();
        $this->delete();
        // remove all detached tags (which are no connection)
        Tag::doesntHave('articles')->doesntHave('nft')->delete();
    }
}
