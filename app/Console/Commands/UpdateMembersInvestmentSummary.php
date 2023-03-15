<?php

namespace App\Console\Commands;

use App\Models\Api\Profit;
use App\Models\Member;
use App\Models\MemberInvestmentSumm;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateMembersInvestmentSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:investment-for-member {user?} {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * for all
     * ./artisan update:investment-for-member
     *
     * by date
     * ./artisan update:investment-for-member --date="start=-3 day"
     * @return int
     */
    public function handle()
    {
        $userId  = $this->argument('user');
        $date = $this->option('date');
        parse_str($date, $output);

        $startDate = null;
        if (isset($output['start'])) {
            $startDate = date('Y-m-d', strtotime($output['start']));
        }

        $this->line('Start updating member investment stats');

        $query = Member::investmentOnly()->active();

        if (is_numeric($userId)) {
            $query->where('id', $userId);
        }

        if ($query->count() === 0) {
            $this->error('No members for update');
            return;
        }

        foreach ($query->get() as $member) {
            $this->info("Start updating for member # {$member->id}");

            $investModel = $member->memberInvestments()->orderBy('invested_date','asc')->first();
            $this->line("The 1st day of investment for member \"{$member->name}\" is {$investModel->invested_date}");

            $queryPrft = Profit::where('day','>=', $investModel->invested_date);
            if (isset($startDate)&&preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/',$startDate)) {
                $queryPrft->where('day','>=',$startDate);

                $dateObj = new \DateTime($startDate);
                $dateObj->modify("-1 day");
                $prevMemberInvestment = $member->memberInvestments()->where('invested_date', $dateObj->format("Y-m-d") )->first();
                $withdrawnProfitUsd = $member->memberInvestments()->where('invested_date', '<=', $dateObj->format("Y-m-d") )->sum('withdrawn_profit_usd');
                $member->setKeepInvestmentData([
                    'total_profit_usd'=> $prevMemberInvestment->total_profit_usd,
                    'withdrawn_profit_usd'=> $withdrawnProfitUsd
                ]);
            }

            $profitsFromApi = $queryPrft->orderBy('day','asc')->get();

            $investSummArr = $member->getInvestmentSummaries(['summary'=>true,'forward_date'=>0])->toArray();
            $lastInvestedUsd = $lastInvestedThisDayUsd = $lastTotalProfitUsd = $lastWithdrawnProfitUsd = $lastCurrentProfitUsd = 0;
            $lastReturnedBtc = '';
            foreach ($profitsFromApi as $p) {
                if (isset($investSummArr[$p->day])) {
                    $this->info("\t{$p->day}: {$p->profit} | DONE invest: {$investSummArr[$p->day]->invested_usd} x {$p->profit} = ".($investSummArr[$p->day]->invested_usd*$p->profit));

                    $member->saveInvestmentSummaryItem($p, $investSummArr[$p->day]);
                    $lastInvestedUsd = $investSummArr[$p->day]->invested_usd;
                    $lastInvestedThisDayUsd = $investSummArr[$p->day]->invested_this_day_usd;
                    $lastTotalProfitUsd = $investSummArr[$p->day]->total_profit_usd;
                    $lastWithdrawnProfitUsd = $investSummArr[$p->day]->withdrawn_profit_usd;
                    $lastCurrentProfitUsd = $investSummArr[$p->day]->current_profit_usd;
                } else {
                    $this->line("\t{$p->day}: {$p->profit} | ---*** | {$p->profit} x {$lastInvestedUsd} = ".($p->profit* $lastInvestedUsd));

                    $item = new \stdClass();
                    $item->invested_usd = $lastInvestedUsd;
                    $item->returned_btc = $lastReturnedBtc;
                    $item->invested_this_day_usd = $lastInvestedThisDayUsd;
                    $item->total_profit_usd = 0;
                    $item->withdrawn_profit_usd = 0;
                    $item->current_profit_usd = 0;
                    $item->invested_date = $p->day;
                    $member->saveInvestmentSummaryItem($p, $item);
                }
            }
        }
    }
}
