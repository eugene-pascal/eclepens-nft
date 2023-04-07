<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
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

}
