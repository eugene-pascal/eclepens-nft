<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPageLocalization extends Model
{
    protected $fillable = [
        'static_page_id',
        'language_id',
        'name',
        'header',
        'text',
        'title',
        'description',
        'keywords'
    ];

    protected $table = 'static_page_localization';

    public $timestamps = false;

    public function static_page()
    {
        return $this->belongsTo('App\Models\StaticPage');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }
}
