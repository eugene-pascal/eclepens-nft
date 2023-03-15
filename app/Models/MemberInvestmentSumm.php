<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\String_;

class MemberInvestmentSumm extends User
{
    /**
     * table name
     */
    protected $table = 'members_investment_summary';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invested_usd','returned_btc','total_profit_usd', 'daily_profit_usd', 'withdrawn_profit_usd', 'current_profit_usd','member_id','invested_date'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo('App\Models\Member','id','member_id');
    }
}
