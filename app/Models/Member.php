<?php

namespace App\Models;

use App\Models\Api\Profit;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\PseudoTypes\Numeric_;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Member extends User
{
    /**
     * @var array double
     */
    protected $keep_investment_data = [
        'total_profit_usd' => 0,
        'withdrawn_profit_usd' => 0
    ];

    /**
     * table name
     */
    protected $table = 'members';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','first_name','last_name', 'email', 'password','description','status','type_account'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @return String
     */
    public function getFullName():String
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    /**
     * Get members active
     */
    public function scopeActive($query)
    {
        return $query->where('members.status','1');
    }

}
