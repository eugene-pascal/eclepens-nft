<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    /**
     * table name
     */
    protected $table = 'statistic_profit_from_api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'day','profit','strategy'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

}
