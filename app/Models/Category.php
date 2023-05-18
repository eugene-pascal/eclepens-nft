<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}

