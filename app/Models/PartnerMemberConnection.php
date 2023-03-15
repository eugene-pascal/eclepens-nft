<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerMemberConnection extends Model
{
    protected $fillable = [
        'partner_id',
        'member_id',
        'notes',
        'approved',
        'created_at'
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    public $timestamps = false;

    protected $table = 'partner_member';

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'id', 'member_id');
    }

    public function partner()
    {
        return $this->belongsTo('App\Models\Member', 'id', 'partner_id');
    }
}
