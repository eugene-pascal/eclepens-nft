<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalSedoCredential extends Model
{
    protected $fillable = [
        'username',
        'password',
        'partnerid',
        'signkey',
        'is_active'
    ];

    /**
     * table name
     */
    protected $table = 'finalsedo_settings';

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
}

