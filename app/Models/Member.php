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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memberInvestments()
    {
        return $this->hasMany('App\Models\MemberInvestmentSumm', 'member_id', 'id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function memberConnection()
    {
        return $this->hasMany('App\Models\PartnerMemberConnection', 'partner_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function partnerConnection()
    {
        return $this->hasOne('App\Models\PartnerMemberConnection', 'member_id', 'id');
    }

    /**
     * Delete partner connection
     */
    public function deletePartnerConnection()
    {
        if (\Auth::user()->isAdmin()) {
            $this->partnerConnection()->delete();
        }
        if (\Auth::user()->isPartner()) {
            $this->partnerConnection()->where('partner_id', \Auth::user()->id)->delete();
        }
    }

    /**
     * Update partner connection status
     *
     * @return bool
     */
    public function updateStatusPartnerConnection():bool
    {
        if (\Auth::user()->isAdmin()) {
            $modelConn = $this->partnerConnection()->first();
            $modelConn->update(['approved' => !$modelConn->approved]);
        }
        if (\Auth::user()->isPartner()) {
            $modelConn = $this->partnerConnection()->where('partner_id', \Auth::user()->id)->first();
            $modelConn->update(['approved' => !$modelConn->approved]);
        }
        return isset($modelConn->approved) ? $modelConn->approved : false ;
    }

    /**
     * If member is partner then get all members
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function getMembers()
    {
        if (!$this->isPartner()) {
             throw new MethodNotAllowedHttpException([],'not allowed method and model is not partner type');
        }
        return $this->hasManyThrough(
                'App\Models\Member',
                'App\Models\PartnerMemberConnection',
                'partner_id', // Foreign key on PartnerMemberConnection table...
                'id', // Foreign key on Member table...
                'id', // Local key on Member table...
                'member_id' // Local key on PartnerMemberConnection table...
            );
    }

    /**
     * @return String
     */
    public function getFullName():String
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    /**
     * For partner
     * Get commission summary
     * @return MemberInvestmentSumm
     */
    public function getCommissionSummary():MemberInvestmentSumm
    {
        if (!$this->isPartner()) {
            throw new MethodNotAllowedHttpException([],'not allowed method and model is not partner type');
        }

        $collection = $this->getMembers()->get();

        $memberIdArr = $collection->map(function ($ref) {
            return $ref->id;
        })->all();

        $model = MemberInvestmentSumm::whereIn('member_id', $memberIdArr)
            ->select([
                DB::raw('ROUND((SUM(daily_profit_usd) / 100) * 10, 2) as total_commission_usd'),
                DB::raw('ROUND((SUM(withdrawn_profit_usd) / 100) * 10, 2) as withdrawn_commission_usd'),
                DB::raw('ROUND((SUM(daily_profit_usd) / 100) * 10, 2) - ROUND((SUM(withdrawn_profit_usd) / 100) * 10, 2) as current_commission_usd'),
            ])
            ->first();

        return $model;
    }

    /**
     * Get account summary
     * @return \stdClass
     */
    public function getAccountSummary()
    {
         $resObj = DB::table('members_account_summary')
            ->where('member_id', $this->id)
            ->first();

         if (empty($resObj)) {
             $resObj = new \stdClass();
             $resObj->id = 0;
             $resObj->account_number = '';
             $resObj->start_date = '';
             $resObj->validity_date = '';
             $resObj->strategy_type = '';
             $resObj->capitalization_status = '';
             $resObj->member_id = $this->id;
         }
         return $resObj;
    }


    /**
     * Get investment summary
     * @return \stdClass
     */
    public function getInvestmentSummary()
    {
        $collection = DB::table('members_investment_summary')
            ->where('member_id', $this->id)
            ->get();

        $resObj = new \stdClass();
        $resObj->invested_usd = $collection->sum('invested_usd');
        $resObj->returned_btc = $collection->sum(function ($btc) {
                return is_numeric($btc->returned_btc) ? $btc->returned_btc : 0 ;
            });
        $resObj->total_profit_usd = $collection->sum('daily_profit_usd');
        $resObj->withdrawn_profit_usd = $collection->sum('withdrawn_profit_usd');
        $resObj->current_profit_usd = $resObj->total_profit_usd - $resObj->withdrawn_profit_usd;

        return $resObj;
    }

    /**
     *
     * Get investment summaries as collection
     *
     * @return \Illuminate\Support\Collection
     */
    public function getInvestmentSummaries($params=[])
    {
        $collection = DB::table('members_investment_summary')
            ->where('member_id', $this->id)
            ->orderBy('invested_date','asc')
            ->get();

        $summaryInvestedUsd = 0;
        $summaryReturnedBtc = 0;
        $collapseCollection = $collection->map(function ($ref) use (&$summaryInvestedUsd, &$summaryReturnedBtc, $params) {
            if (!empty($params['summary'])) {
                $ref->invested_this_day_usd = $ref->invested_usd;
                $summaryInvestedUsd += $ref->invested_usd;
                $ref->invested_usd = $summaryInvestedUsd;
                $summaryReturnedBtc += !empty($ref->returned_btc)&&is_numeric($ref->returned_btc) ? $ref->returned_btc : '0' ;
                $ref->returned_btc = $summaryReturnedBtc;
            }
            if (!empty($params['forward_date'])&&is_numeric($params['forward_date'])) {
                $keyDate = date('Y-m-d', strtotime($ref->invested_date." +".$params['forward_date']." days"));
                $ref->invested_date = $keyDate;
            } else {
                $keyDate = $ref->invested_date;
            }
            return [$keyDate => $ref];
        })->collapse();

        return $collapseCollection;
    }


    /**
     * Get members active
     */
    public function scopeActive($query)
    {
        return $query->where('members.status','1');
    }

    /**
     * Get members Only with investment
     */
    public function scopeInvestmentOnly($query)
    {
        return $query->has('memberInvestments', '>=', 1);
        //        return $query
        //            ->select('members.*')
        //            ->join('members_investment_summary', function($q) {
        //                $q->on('members.id', '=', 'members_investment_summary.member_id');
        //            })->groupBy('members.id');
    }

    /**
     * Save investment summary item
     */
    public function saveInvestmentSummaryItem(Profit $prftApi, $item)
    {
        if (is_object($item) && isset($item->invested_date)) {
            $investModel = $this->memberInvestments()
                ->where('invested_date', $item->invested_date)
                ->where('member_id', $this->id)
                ->first();

            if (!empty($investModel)) {
                $this->keep_investment_data['total_profit_usd'] += number_format($item->invested_usd * $prftApi->profit, 2, '.', '');
                $this->keep_investment_data['withdrawn_profit_usd'] += number_format($item->withdrawn_profit_usd, 2, '.', '');
                $investModel->daily_profit_usd = number_format($item->invested_usd * $prftApi->profit, 2, '.', '');
                $investModel->total_profit_usd = $this->keep_investment_data['total_profit_usd'];
                $investModel->withdrawn_profit_usd = number_format($item->withdrawn_profit_usd, 2, '.', '');
                $investModel->current_profit_usd = ($this->keep_investment_data['total_profit_usd']-$this->keep_investment_data['withdrawn_profit_usd']);

                if (!$investModel->isClean()) {
                    $investModel->save();
                }

            } else {
                $this->keep_investment_data['total_profit_usd'] += number_format($item->invested_usd * $prftApi->profit, 2, '.', '');
                $investModel = new MemberInvestmentSumm();
                $investModel->daily_profit_usd = number_format($item->invested_usd * $prftApi->profit, 2, '.', '');
                $investModel->total_profit_usd = $this->keep_investment_data['total_profit_usd'];
                $investModel->withdrawn_profit_usd = number_format($item->withdrawn_profit_usd, 2, '.', '');
                $investModel->current_profit_usd = ($this->keep_investment_data['total_profit_usd'] - $item->withdrawn_profit_usd);
                $investModel->member_id = $this->id;
                $investModel->invested_date = $item->invested_date;
                $investModel->save();
            }
        }
    }

    /**
     * Set keep investment data
     * @param array $data
     */
    public function setKeepInvestmentData(array $data=[])
    {
        $this->keep_investment_data['total_profit_usd'] = isset($data['total_profit_usd']) ? $data['total_profit_usd'] : 0 ;
        $this->keep_investment_data['withdrawn_profit_usd'] = isset($data['withdrawn_profit_usd']) ? $data['withdrawn_profit_usd'] : 0 ;
    }
}
