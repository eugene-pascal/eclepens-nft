<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

class Tag extends Model
{

    /**
     * table name
     */
    protected $table = 'terms';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name,'-');
            }
        });
    }

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function articles():MorphToMany
    {
        return $this->morphedByMany(Article::class, 'taggable', 'terms_taggable','term_id');
    }


    /**
     * Get all of the NFT that are assigned this tag.
     */
    public function nft():MorphToMany
    {
        return $this->morphedByMany(Nft::class, 'taggable', 'terms_taggable','term_id');
    }
}

