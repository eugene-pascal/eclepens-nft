<?php
namespace App\Classes\Sudo;

use App\Models\FinalSedoCredential;
use Illuminate\Support\Arr;

class BasicApi {

    /**
     * @param array $list
     * @param array $params
     * @return array
     */
    public function getDomains(Array $list=[], Array $params=[]):array
    {
        if (empty($params)) {
            return [];
        }

        $_period = 0;
        if ($params['radios'] == 1) {
            $_period = 0; // one day
            if (preg_match('|month|', $params['predefined_day'])) {
                $_period = 2; // one month
            }
            $_date = date('Y-m-d', strtotime("{$params['predefined_day']}"));
        }
        elseif ($params['radios'] == 2) {
            $_period = 3; // range months
        }
        elseif ($params['radios'] == 3) {
            $_period = 1; // last 31 days
            $_date = date('Y-m-01');
        }

        $returnDataTotal = [];
        $returnData = [];
        $periodString = '';
        $totalData = [
            'visitors' => 0,
            'clicks' => 0,
            'earnings' => 0
        ];
        $finalSedoCredentials = FinalSedoCredential::active()->get();
        if (0 == $finalSedoCredentials->count()) {
            return [];
        }
        foreach ($finalSedoCredentials as $indexCredentials => $credentialItem) {
            foreach ($list as $domain) {
                try {
                    // Create a new client by providing the endpoint to the constructor.
                    $client = new \SoapClient(
                        null,
                        [
                            'location' => 'https://api.sedo.com/api/v1/',
                            'soap_version' => SOAP_1_1,
                            'encoding' => 'UTF-8',
                            'uri' => 'urn:SedoInterface',
                            'style' => SOAP_RPC,
                            'use' => SOAP_ENCODED,
                        ]
                    );

                    //0 - One day. (requires $date to be set)
                    //1 - Last 31 days as day by day summary.
                    //2 - One month. (requires $date to be set)
                    //3 - Last 12 months.
                    //4 - Last 31 days as domain summary.

                    // Set the values for the array
                    $settings = [
                        'username' => $credentialItem->username,
                        'password' => $credentialItem->password,
                        'partnerid' => $credentialItem->partnerid,
                        'signkey' => $credentialItem->signkey,
                        'domain' => $domain,
                        'period' => $_period,
                        'date' => $_date ?? date('Y-m-d'), //  Mandatory for $period values 0 and 2.
                        'startfrom' => 0,
                        'results' => 0,
                    ];

                    $result = $client->DomainParkingFinalStatistics($settings);

                    if (!is_array($result) && is_string($result)) {
                        $returnData[$domain] = $result;
                    } elseif (is_array($result)) {
                        if ($params['radios'] == 1) {
                            $returnData[$domain] = [
                                'data' => $result,
                                'info' => sprintf('Statistic for %s', date((preg_match('|month|', $params['predefined_day']) ? 'F' : 'Y-m-d'), strtotime("{$params['predefined_day']}")))
                            ];
                            $periodString = $returnData[$domain]['info'];
                            $totalData['visitors'] += (int)$result[0]->visitors;
                            $totalData['clicks'] += (int)$result[0]->clicks;
                            $totalData['earnings'] += (float)$result[0]->earnings;
                        } elseif ($params['radios'] == 2 || $params['radios'] == 3) {

                            if ($params['radios'] == 3) {
                                list($dateStart, $dateEnd) = explode(' - ', $params['date_range_picker']);
                            } else {
                                $dateStart = $params['month_picker1'] . '-01';
                                $dateEnd = $params['month_picker2'] . '-01';
                            }

                            $pickedData = [];
                            $summaryData = new \stdClass();
                            $summaryData->domain = $domain;
                            $summaryData->visitors = 0;
                            $summaryData->clicks = 0;
                            $summaryData->earnings = 0;

                            foreach ($result as $item) {
                                if ($item->date >= $dateStart && $item->date <= $dateEnd) {
                                    $pickedData[] = $item;
                                    $summaryData->visitors += $item->visitors;
                                    $summaryData->clicks += $item->clicks;
                                    $summaryData->earnings += $item->earnings;

                                    $totalData['visitors'] += (int)$item->visitors;
                                    $totalData['clicks'] += (int)$item->clicks;
                                    $totalData['earnings'] += (float)$item->earnings;
                                }
                            }

                            if ($params['radios'] == 3) {
                                $_info = sprintf('Statistic from %s till %s', $dateStart, $dateEnd);
                            } else {
                                $_info = sprintf('Statistic from %s till %s', date('F', strtotime($params['month_picker1'] . '-01')), date('F', strtotime($params['month_picker2'] . '-01')));
                            }
                            $returnData[$domain] = [
                                'raw' => $pickedData,
                                'data' => [$summaryData],
                                'info' => $_info
                            ];
                            $periodString = $_info;
                        }
                    }
                } catch (\Exception $e) {
                    $returnData[$domain] = $e->getMessage();
                }
            }

            foreach ($returnData as $returnDomain => $returnItem) {
                if (Arr::accessible($returnItem) && (!isset($returnDataTotal[$returnDomain]) || is_string($returnDataTotal[$returnDomain]))) {
                    $returnDataTotal[$returnDomain] = $returnItem;
                }
                elseif (is_string($returnItem) && !isset($returnDataTotal[$returnDomain])) {
                    $returnDataTotal[$returnDomain] = $returnItem;
                }
            }
        }

        return [
            'data' => $returnDataTotal,
            'info' => $periodString,
            'total' => $totalData
        ];
    }
}
