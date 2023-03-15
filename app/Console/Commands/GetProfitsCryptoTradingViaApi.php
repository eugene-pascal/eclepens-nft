<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GetProfitsCryptoTradingViaApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:profits-crypto-trading {strategy} {--date=}';

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
     * @return int
     */
    public function handle()
    {
        $strategy = $this->argument('strategy');

        if (!in_array($strategy, ['balanced'])) {
            $this->error('No strategy: '.$strategy);
        }
        $date = $this->option('date');
        parse_str($date, $output);

        $this->line('Start gathering profit statistic');

        $rangeDate = [];
        if (isset($output['start'])&&isset($output['end'])) {
            $rangeDate['start'] = date('Y-m-d', strtotime($output['start']));
            $rangeDate['end'] = date('Y-m-d', strtotime($output['end']));

            if ($rangeDate['start']>$rangeDate['end']) {
                $this->error('Start date cannot be more than end date');
                return;
            }
            if ($rangeDate['end'] >= date('Y-m-d')) {
                $this->error('End date cannot be more than today');
                return;
            }
        } else
        if (isset($output['date'])) {
            $rangeDate['date'] = $output['date'];
            if ($rangeDate['date'] >= date('Y-m-d')) {
                $this->error('Setted day date cannot be more than today');
                return;
            }
        } else {
            $rangeDate['date'] = date('Y-m-d', strtotime('-1 day'));
        }

        $apiUrlBasePattern = 'https://mamig.com/api/cryptotrading/v1/profits/';

        $urlForSubmitting = $apiUrlBasePattern;
        $client = new \GuzzleHttp\Client();

        $postData = [
            \GuzzleHttp\RequestOptions::JSON => [
                'key'=>'g]IxiKvV<eT|bdyI$J8A~^Yd VmO(k-1=Y (__GNRxK?!Q9oqT-(9,}=OM*R<EBm',
                'strategies' => [$strategy]
            ] + $rangeDate
        ];

        $responseRaw = $client->post($urlForSubmitting, $postData)
            ->getBody()
            ->getContents();

        $this->info(PHP_EOL.'Done');

        do {
            $responseArr = json_decode( empty($responseArr) ? $responseRaw : $responseArr, true);
        } while(!is_array($responseArr));

        $bar = $this->output->createProgressBar( !empty($responseArr[0]['profits']) ? count($responseArr[0]['profits']) : 1 );
        $bar->start();

        $begin = new \DateTime($rangeDate['start'] ?? $rangeDate['date']);
        $end = new \DateTime($rangeDate['end'] ?? $rangeDate['date']);
        for($i = $begin, $j=0; $i <= $end; $i->modify('+1 day'), $j++){
            if (isset($responseArr[0]['profits'][$j])) {
                $profitVal = $responseArr[0]['profits'][$j];
            }
            elseif (0 === $j && isset($responseArr[0]['profit']) && is_numeric($responseArr[0]['profit'])) {
                $profitVal = $responseArr[0]['profit'];
            } else {
                continue;
            }
            $bar->advance();
            usleep(300000);
            echo "\t".$i->format("Y-m-d").': Inserting profit = '.$profitVal.PHP_EOL;

            DB::table('statistic_profit_from_api')
                ->updateOrInsert(
                    ['day' => $i->format("Y-m-d"), 'strategy' => $strategy],
                    [
                        'day' => $i->format("Y-m-d"),
                        'profit' => $profitVal,
                        'strategy' => $strategy
                    ]
                );
        }
        $bar->finish();
        echo PHP_EOL.PHP_EOL;
    }
}
