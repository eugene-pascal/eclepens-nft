<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;


class StaticPage extends Model
{
    use NodeTrait;

    protected $fillable = [
        '_lft',
        '_rgt',
        'parent_id',
        'slug',
        'sort',
        'display',
        'visibility'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'display' => 'boolean',
    ];

    public static function boot() {
        parent::boot();
        self::deleting(function($page) {
            $page->staticPageLocalization()->delete();
        });
    }

    public function scopeDisplayed($query) {
        return $query->where('display', true);
    }

    public function scopeVisible($query) {

        $user = Auth::guard('sanctum')->user();
        $query->where(function ($query) use($user) {
            $query->where('visibility', 'all');
            if (empty($user)) {
                $query->orWhere('visibility', 'guest');
            } else {
                $query->orWhere('visibility', 'auth');
            }
        });
        return $query;
    }

    public function staticPageLocalization()
    {
        return $this->hasMany('App\Models\StaticPageLocalization', 'static_page_id', 'id');
    }
}

