<?php

namespace App\Console\Commands;

use App\Models\FinalSedoCredential;
use Illuminate\Console\Command;

class PostBackToFinalSedo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postback:finalsedo {user?} {--day_ago=}';

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
        $currScript = 'artisan postback:finalsedo';
        $ps = `ps -wef | grep "{$currScript}" | awk '{print $8 "|" $11}'`;
        $ps_array = explode("\n", trim($ps));

        $nProcessInMemory = 0;
        foreach ($ps_array as $ps_line) {
            $row = explode('|', trim($ps_line));
            if (('php' === $row[0] || preg_match('|php|i', $row[0]))) {
                if (2 === ++$nProcessInMemory) {
                    $this->error("Script is being executed now and It can't be executed before the 1st one will be finished");
                    return 0;
                }
            }
        }

        $param = $this->option('day_ago', '-1 days');
        $userId  = $this->argument('user');

        $day = date('Y-m-d', strtotime($param));

        if (!preg_match('|^\d{4}-\d{1,2}-\d{1,2}$|', $day) || '1970-01-01' === $day) {
            $this->error("Invalid day {$day}");
            return 0;
        }


        $this->info("Gathering info for date: {$day}");

        if (empty($userId)) {
            $query = FinalSedoCredential::active();
            $this->info(">>> Gathering info from all active account");
        } else {
            $query = FinalSedoCredential::active()->where(['username' => $userId]);
            if ($query->count() === 0) {
                $this->error("No credentials with username: {$userId}");
                return 0;
            }
        }
        foreach ($query->cursor() as $credentialRow) {

            $parsedData = [];
            $iter = 0;
            $posStart = 0;
            $posStep = 9000;

            do {
                echo "\033[0;33m\t - start from: {$posStart} with step: {$posStep}\033[0m\n";
                sleep(3);

                $getResponseAsXML = $this->getDomainParkingSubId($day, 'xml', $posStart, $posStep, $credentialRow->toArray());

                $rsltObj = simplexml_load_string($getResponseAsXML);

                $countStep = 0;

                foreach ($rsltObj->item as $key => $row) {
                    if (is_object($row->c1)) {
                        $_c1 = (array)$row->c1;
                        $_c1 = $_c1[0] ?? '';
                    } else {
                        $_c1 = $row->c1;
                    }

                    if (is_object($row->c2)) {
                        $_c2 = (array)$row->c2;
                        $_c2 = $_c2[0] ?? '';
                    } else {
                        $_c2 = $row->c2;
                    }

                    if (is_object($row->c3)) {
                        $_c3 = (array)$row->c3;
                        $_c3 = $_c3[0] ?? '';
                    } else {
                        $_c3 = $row->c3;
                    }

                    $countStep++;
                    $parsedData[++$iter] = [
                        (is_object($row->date) ? ((array)$row->date)[0] ?? '' : $row->date),
                        (is_object($row->domain) ? ((array)$row->domain)[0] ?? '' : $row->domain),
                        $_c1,
                        $_c2,
                        $_c3,
                        (is_object($row->uniques) ? ((array)$row->uniques)[0] ?? '' : $row->uniques),
                        (is_object($row->clicks) ? ((array)$row->clicks)[0] ?? '' : $row->clicks),
                        (is_object($row->earnings) ? ((array)$row->earnings)[0] ?? '' : $row->earnings),
                    ];
                }

                if ($countStep < $posStep) {
                    break;
                }
                $posStart += $posStep;
            } while (true);


            // SAVE TO FILE

            $pathRel = env('REPORT_CSV_PATH_REL', '/storage/report/');
            $dateFolders = '/'.date('Y').'/'.date('M');
            if (!file_exists(base_path() . $pathRel . $credentialRow->username . $dateFolders)) {

                if (!file_exists(base_path() . $pathRel . $credentialRow->username)) {
                    $resCreateDir = mkdir(base_path() . $pathRel . $credentialRow->username, 0777, true);

                    if (!$resCreateDir) {
                        $this->error('Cannot create dir');
                        return 0;
                    }
                }

                $resCreateDir = mkdir(base_path() . $pathRel . $credentialRow->username . $dateFolders, 0777, true);
                if (!$resCreateDir) {
                    $this->error('Cannot create dir YY/MM');
                    return 0;
                }

            }

            $csvData = array_merge([
                ['Date', 'Domain', 'c1', 'c2', 'c3', 'Uniques', 'Clicks', 'Earnings']
            ], $parsedData);

            $fp = fopen(base_path() . $pathRel . $credentialRow->username . $dateFolders . '/' . $day . '.csv', 'w');
            foreach ($csvData as $fields) {
                fputcsv($fp, $fields);
            }
            fclose($fp);
            echo "\033[0;33m\tSaved data in CSV file: " . base_path() . $pathRel . $credentialRow->username . $dateFolders . '/' . $day . '.csv' . "\033[0m\n";

            // POSTBACK to RedTrack

            $url = "https://official-www.com/postback?clickid=%s&sum=%s&timestamp=%s&type=finalsedo";

            if (!empty($parsedData)) {
                echo "\n\033[0;36m\tStart to send (" . count($parsedData) . ") via API to redtrack \033[0m\n";
                sleep(5);

                $fp2 = fopen(base_path() . $pathRel . $credentialRow->username . $dateFolders . '/' . $day . '_api_response.csv', 'w');
                foreach ($parsedData as $row) {
                    $date = new \DateTime($row[0] . ' 19:59:59');
                    $postUrl = sprintf($url, $row[2], $row[7], $date->getTimestamp());
                    echo "\t" . $postUrl . PHP_EOL;

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_URL, $postUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    if (is_string($response)) {
                        $responseArr = json_decode($response, true);
                        if (isset($responseArr['status']) && $responseArr['status'] == 1) {
                            echo "\033[0;32m\t{$response}\033[0m\n";
                        } else {
                            echo "\033[0;31m\t{$response}\033[0m\n";
                        }
                        fputcsv($fp2, [date('Y-m-d H:i:s'),$postUrl, trim($response)]);
                    }
                    usleep(140000 / 2);
                }
                fclose($fp2);
            }
        }
    }

    /**
     * @param mixed ...$params
     * @return string
     */
    private function getDomainParkingSubId(...$params) {
        // URL to Sedo's API
        $baseUrl = 'https://api.sedo.com/api/v1/DomainParkingSubIdReport?';

        $date = $params[0] ?? date('Y-m-d');
        $outputType = $params[1] ?? 'json';

        $startfrom = $params[2] ?? 0 ;
        $resultsPerRequest = $params[3] ?? 100 ;

        if (empty($params[4])) {
            return 0;
        }

        /* API function parameters */
        $params = [
            'username'      => $params[4]['username'],
            'password'      => $params[4]['password'],
            'partnerid'     => $params[4]['partnerid'],
            'signkey'       => $params[4]['signkey'],
            'output_method' => $outputType,
            'date'          => $date,
            'final'         => true,
            'startfrom'     => $startfrom,
            'results'       => $resultsPerRequest,
        ];


        echo "\033[0;35m\t - username: {$params['username']}\033[0m\n";
        echo "\033[0;35m\t".$baseUrl . http_build_query($params)."\033[0m\n";
        sleep(3);

        $response = '';
        /* build request URL */
        $request = $baseUrl . http_build_query($params);

        /* fire API request */
        $fp = @fopen($request, 'r');

        /* read response line by line */
        while (!@feof($fp)) {
            $response.= fread($fp, 4096);
        }

        /* close the connection */
        fclose($fp);
        return $response;
    }
}
