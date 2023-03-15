<?php

namespace App\Http\Controllers\Cpanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cpanel\KDTableRequest;
use App\Http\Requests\Cpanel\Partners\OnlyPartnerAllowed;
use App\Http\Requests\Cpanel\Statistic\Request;
use App\Http\Resources\Cpanel\Api\Statistic\ProfitCollection;
use App\Http\Resources\Cpanel\KDTablePaginationCollection;
use App\Models\Api\Profit;
use App\Models\Member;
use App\Models\MemberInvestmentSumm;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StatisticController extends Controller
{
    /**
     * Get the list of attributes
     */
    public function apiProfitsList(Request $request)
    {
        return view('cpanel.statistic.api-profit-list', [
        ]);
    }

    /**
     * Get common api statistic earnings
     */
    public function apiProfitsListKTDatatable(KDTableRequest $request)
    {
        if (!\Auth::user()->isAdmin()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $sortData = $request->get('sort');
        $queryData = $request->get('query');

        $query = Profit::query();

        if (!empty($queryData)) {
            if (!empty($queryData['query_search'])) {
                $query
                    ->where(function ($query) use ($queryData) {
                        $query->where('profit', 'like', '%'.trim($queryData['query_search']).'%')
                            ->orWhere('day', 'like', '%'.trim($queryData['query_search']).'%');
                    });
            }
        }
        if (!empty($sortData)) {
            if (Schema::hasColumn('statistic_profit_from_api', $sortData['field'])) {
                $query->orderBy($sortData['field'], $sortData['sort']);
            } else
                $query->orderBy('day', 'desc');
        } else {
            $query->orderBy('day', 'desc');
        }

        $onPage = intval($request->pagination['perpage'] ?? 20);
        $pager = $query->paginate($onPage);
        if ($request->page && $pager->isEmpty()) {
            $pager = $query->paginate($onPage, ['*'], 'page', 1);
        }

        return response()->json( [
            'meta'=> new KDTablePaginationCollection($pager),
            'data'=> ProfitCollection::collection($pager)
        ]);
    }

    /**
     *
     * @param Request $request
     */
    public function apiProfitsChartForMember(Member $member, Request $request)
    {
        if (\Auth::user()->isMember() && \Auth::user()->id != $member->id) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        // The first member investment model
        $memberInvestModel = $member->memberInvestments()->orderBy('invested_date','asc')->first();

        if (preg_match('|^daterange_(\d+-\d+-\d+)_(\d+-\d+-\d+)$|', $request->date_range, $match)) {
            $rangeDates = [$match[1], $match[2]];
        }
        elseif ('all_time' === $request->date_range) {
            $startDateForAllTime = isset($memberInvestModel) ? $memberInvestModel->invested_date : date('Y-m-01') ;
            $rangeDates = [$startDateForAllTime,date('Y-m-d')];
        }
        elseif ('last_week' === $request->date_range) {
            $rangeDates = [date('Y-m-d', strtotime('-1 week')),date('Y-m-d')];
        }
        elseif ('current_month' === $request->date_range) {
            $rangeDates = [date('Y-m-01'), date('Y-m-d')];
        }
        elseif ('last_month' === $request->date_range) {
            $rangeDates = [date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1)), date("Y-m-d", mktime(0, 0, 0, date("m"), 0))];
        } else {
            $rangeDates = [date('Y-m-d', strtotime('-1 week')), date('Y-m-d')];
        }

        $returnData = [];
        $arrInvestedUsd = $member->getInvestmentSummaries(['summary'=>true,'forward_date'=>0])->toArray();
        $query = Profit::whereBetween('day',$rangeDates)
            ->where('day','>=',(isset($memberInvestModel) ? $memberInvestModel->invested_date : $member->getAccountSummary()->start_date ))
            ->orderBy('day','asc');

        if (!empty($arrInvestedUsd)) {
            $firstEl = reset($arrInvestedUsd);
            $query->where('day','>=', $firstEl->invested_date);
        }

        $invested_usd = 0;
        foreach ($arrInvestedUsd as $keyDate => $item) {
            if ($keyDate < $rangeDates[0]) {
                $invested_usd = $arrInvestedUsd[$keyDate]->invested_usd;
            } else {
                break;
            }
        }
        $totalProfit = 0;
        $totalWithdrawal = 0;
        $returnData['profit'] = $query->get()->map(function ($ref) use ($arrInvestedUsd, &$invested_usd, &$totalProfit, &$totalWithdrawal ) {
            if (isset($arrInvestedUsd[$ref->day])) {
                $invested_usd = $arrInvestedUsd[$ref->day]->invested_usd;
            }
            $totalProfit+=$ref->profit * $invested_usd;
            $totalWithdrawal+=$arrInvestedUsd[$ref->day]->withdrawn_profit_usd;
            return [$ref->day => number_format($ref->profit * $invested_usd , 2,'.', '')];
        })->collapse();

        return response()->json( [
            'data' => $returnData,
            'total' => [
                'profit' => number_format($totalProfit, 2),
                'withdrawal' => number_format($totalWithdrawal, 2),
                'remains' => number_format($totalProfit - $totalWithdrawal, 2),
            ]
        ]);
    }


    /**
     *
     * @param Request $request
     */
    public function apiProfitsChartPieForMember(Member $member, Request $request)
    {
        if (\Auth::user()->isMember() && \Auth::user()->id != $member->id) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        // The first member investment model
        $memberInvestModel = $member->memberInvestments()->orderBy('invested_date','asc')->first();

        if ('all_time' === $request->date_range) {
            $collection = $member->memberInvestments();
        } else {
            $collection = $member->memberInvestments();
        }

        $data = [
            'invested_usd' => (double)$collection->sum('invested_usd'),
            'total_profit_usd' => (double)$collection->sum('daily_profit_usd'),
            'withdrawn_profit_usd' => (double)$collection->sum('withdrawn_profit_usd')
        ];

        $data['current_profit_usd'] = $data['total_profit_usd'] - $data['withdrawn_profit_usd'];

        $percent = [
            'total_profit_usd' => 100,
            'withdrawn_profit_usd' => round($data['withdrawn_profit_usd'] / ( $data['total_profit_usd'] / 100 )),
            'current_profit_usd' => round($data['current_profit_usd'] / ( $data['total_profit_usd'] / 100 ))
        ];
        return response()->json( [
            'date_range' => $request->date_range,
            'data' => $data,
            'percent' => $percent
        ]);
    }



    /**
     *
     * @param Request $request
     */
    public function apiProfitsChartColumnForMember(Member $member, Request $request)
    {
        if (\Auth::user()->isMember() && \Auth::user()->id != $member->id) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        // The first member investment model
        $memberInvestModel = $member->memberInvestments()->orderBy('invested_date','asc')->first();

        if (preg_match('|^daterange_(\d+-\d+-\d+)_(\d+-\d+-\d+)$|', $request->date_range, $match)) {
            $startDateForAllTime = isset($memberInvestModel) ? $memberInvestModel->invested_date : date('Y-m-01') ;
            $rangeDates = [$match[1], $match[2]];
        }
        elseif ('all_time' === $request->date_range) {
            $startDateForAllTime = isset($memberInvestModel) ? $memberInvestModel->invested_date : date('Y-m-01') ;
            $rangeDates = [$startDateForAllTime,date('Y-m-d')];
        }
        elseif ('last_week' === $request->date_range) {
            $rangeDates = [date('Y-m-d', strtotime('-1 week')),date('Y-m-d')];
        }
        elseif ('last_10days' === $request->date_range) {
            $rangeDates = [date('Y-m-d', strtotime('-10 days')),date('Y-m-d')];
        }
        elseif ('current_month' === $request->date_range) {
            $rangeDates = [date('Y-m-01'), date('Y-m-d')];
        }
        elseif ('last_month' === $request->date_range) {
            $rangeDates = [date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1)), date("Y-m-d", mktime(0, 0, 0, date("m"), 0))];
        } else {
            $rangeDates = [date('Y-m-d', strtotime('-1 week')), date('Y-m-d')];
        }

        $query = $member->memberInvestments()
            ->whereBetween('invested_date',$rangeDates)
            ->orderBy('invested_date', 'asc');


        $returnData = $query->get()->map(function ($ref)  {
            $data = [];
            $data[$ref->invested_date] = [
                'total_profit_usd' => $ref->total_profit_usd,
                'withdrawn_profit_usd' => $ref->withdrawn_profit_usd,
                'current_profit_usd' => $ref->current_profit_usd,
            ];
            return $data;
        })->all();

        return response()->json( [
            'data' => $returnData
        ]);
    }

    /**
     *
     * @param Request $request
     */
    public function apiProfitsChartBarForMember(Member $member, Request $request)
    {
        if (\Auth::user()->isMember() && \Auth::user()->id != $member->id) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }
        // The first member investment model
        $memberInvestModel = $member->memberInvestments()->orderBy('invested_date','asc')->first();
        $startDateForAllTime = isset($memberInvestModel) ? $memberInvestModel->invested_date : date('Y-01-01') ;
        $rangeDates = [$startDateForAllTime,date('Y-m-d')];

        $query = $member->memberInvestments()
            ->whereBetween('invested_date',$rangeDates)
            ->orderBy('invested_date', 'asc');


        $investedUsdForAllPeriod = (double)$query->sum('invested_usd');

        if ('per_year' === $request->date_range) {
            $dateLabel = 'Y';
        }
        elseif ('per_month' === $request->date_range) {
            $dateLabel = 'M';
        }
        elseif ('per_week' === $request->date_range) {
            $dateLabel = 'W';
        }

       $collection = $query->get()->groupBy(function($ref) use ($dateLabel) {
                return Carbon::parse($ref->invested_date)->format($dateLabel);
            });

        $returnData = $collection->map(function ($ref, $day) use ($investedUsdForAllPeriod, $dateLabel, $member)  {
            $percentArr = [
                'last_invest' => 0,
                'curr_values' => 0
            ];

            $ref->each(function ($item, $key) use (&$percentArr, $member, $ref) {
                if ($item->invested_usd > 0) {
                    $percentArr['last_invest'] += $item->invested_usd;
                } else
                if (empty($percentArr['last_invest']) || $percentArr['last_invest'] <= 0) {
                    $percentArr['last_invest'] += (double)$member->memberInvestments()
                        ->where('invested_usd','>', 0)
                        ->where('invested_date','<=',$ref->min('invested_date'))
                        ->orderBy('invested_date','desc')
                        ->sum('invested_usd');
                }

                $curr = $item->daily_profit_usd / ($percentArr['last_invest'] / 100);
                $percentArr['curr_values'] +=  $curr;
            });

            $data = [
                'total_profit' =>  (double)$ref->sum('daily_profit_usd'),
                'profit_for_all_time' =>  $investedUsdForAllPeriod,
                'profit_for_last_time' => $percentArr['curr_values'],
                'title' => $day
            ];

            if ('W' === $dateLabel) {
                $year = date('Y', strtotime($ref->min('invested_date')));
                $week = $day;
                $dt = new \DateTime();
                $dt->setISODate($year, $week);
                $ret = [];
                $ret['week_start'] = $dt->format('Y-m-d');
                $dt->modify('+6 days');
                $ret['week_end'] = $dt->format('Y-m-d');
                $data['title'] = "{$ret['week_start']} .. {$ret['week_end']}";
            }
            elseif ('M' === $dateLabel) {
                $year = date('Y', strtotime($ref->min('invested_date')));
                $data['title'].= ", ".$year;
            }

            // $percent = $data['total_profit'] / ($investedUsdForAllPeriod / 100);
            $data['percent'] = number_format($percentArr['curr_values'],2,'.','');
            return $data;
        })->all();


        return response()->json( [
            'data' => $returnData,
        ]);
    }



    /**
     * Partner commissions
     *
     * @param Request $request
     */
    public function apiCommissionFromMembersChartForPartner(OnlyPartnerAllowed $request)
    {
        if (!\Auth::user()->isPartner()) {
            return ['status'=>'error', 'message'=>'no access permitted'];
        }

        $collection = \Auth::user()->getMembers()->get();
        $startInvestDate = null;
        $memberIdArr = $collection->map(function ($ref) use (&$startInvestDate) {
            $holdInvestMemberModel = $ref->memberInvestments()->orderBy('invested_date','asc')->first();
            $holdInvestDate = isset($holdInvestMemberModel) ? $holdInvestMemberModel->invested_date : null ;
            if (!empty($holdInvestDate)) {
                if (!empty($startInvestDate) && $startInvestDate > $holdInvestDate) {
                    $startInvestDate = $holdInvestDate;
                } elseif (empty($startInvestDate)) {
                    $startInvestDate = $holdInvestDate;
                }
            }
            return $ref->id;
        })->all();

        if (preg_match('|^daterange_(\d+-\d+-\d+)_(\d+-\d+-\d+)$|', $request->date_range, $match)) {
            $rangeDates = [$match[1], $match[2]];
        }
        elseif ('all_time' === $request->date_range) {
            $startDateForAllTime = isset($startInvestDate) ? $startInvestDate : date('Y-m-01') ;
            $rangeDates = [$startDateForAllTime,date('Y-m-d')];
        }
        elseif ('last_week' === $request->date_range) {
            $rangeDates = [date('Y-m-d', strtotime('-1 week')),date('Y-m-d')];
        }
        elseif ('current_month' === $request->date_range) {
            $rangeDates = [date('Y-m-01'), date('Y-m-d')];
        }
        elseif ('last_month' === $request->date_range) {
            $rangeDates = [date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1)), date("Y-m-d", mktime(0, 0, 0, date("m"), 0))];
        } else {
            $rangeDates = [date('Y-m-d', strtotime('-1 week')), date('Y-m-d')];
        }

        $query = MemberInvestmentSumm::whereIn('member_id', $memberIdArr)
            ->select([
                DB::raw('ROUND((SUM(invested_usd) / 100) * 10, 2) as invested_usd'),
                DB::raw('ROUND((SUM(total_profit_usd) / 100) * 10, 2) as total_profit_usd'),
                DB::raw('ROUND((SUM(daily_profit_usd) / 100) * 10, 2) as daily_profit_usd'),
                DB::raw('ROUND((SUM(withdrawn_profit_usd) / 100) * 10, 2) as withdrawn_profit_usd'),
                DB::raw('ROUND((SUM(current_profit_usd) / 100) * 10, 2) as current_profit_usd'),
                DB::raw('invested_date')
            ])
            ->whereBetween('invested_date',$rangeDates)
            ->groupBy('invested_date')
            ->orderBy('invested_date','asc');

        $totalProfit = MemberInvestmentSumm::whereIn('member_id', $memberIdArr)
            ->whereBetween('invested_date',$rangeDates)
            ->sum('daily_profit_usd');
        $totalProfit = ($totalProfit / 100) * 10;
        $totalWithdrawal =MemberInvestmentSumm::whereIn('member_id', $memberIdArr)
            ->whereBetween('invested_date',$rangeDates)
            ->sum('withdrawn_profit_usd');
        $totalWithdrawal = ($totalWithdrawal / 100) * 10 ;

        $returnData['profit'] = $query->get()->map(function ($ref) {
            return [$ref->invested_date => $ref->daily_profit_usd];
        })->collapse();



        return response()->json( [
            'data' => $returnData,
            'total' => [
                'profit' => number_format($totalProfit, 2,'.', ''),
                'withdrawal' => number_format($totalWithdrawal, 2,'.', ''),
                'remains' => number_format($totalProfit - $totalWithdrawal, 2,'.', ''),
            ]
        ]);
    }
}
