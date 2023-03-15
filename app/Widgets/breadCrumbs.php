<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class breadCrumbs extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * breadcrumbs structure
     *
     * @var array
     */
    protected $output = [];

    /**
     * prepend dashboard link
     *
     * @var bool
     */
    protected $prependDashboard = true;


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $url = array_get($this->config,  'url', \Request::path());
        $holdUrl = '';
        $url = preg_replace_callback('|\d+$|si', function($match) use ($url, &$holdUrl) { 
                $holdUrl = $url;
                return '{id}'; 
            }, $url);

        $menuStructureArr = config('cpanelmenu.structure');
        $collect = collect(array_dot($menuStructureArr));

        $filtered = $collect->filter(function ($value, $key) use ($url) {
            return is_array($value) ? false : trim($value,'/') === trim($url,'/');
        });

        if (isset($this->prependDashboard)) {
            $this->output[] = [
                'label' => reset($menuStructureArr)['label'],
                'url' => reset($menuStructureArr)['url'],
            ];
        }
        if ($filtered->count() > 0 && ($arr = $filtered->all())) {

            [$keys, $urls] = array_divide($arr);

            if (isset($keys[0]) && preg_match_all('|(\d+)\.|', $keys[0], $match)) {
                for ($i=0, $j=count($this->output);$i<count($match[1]);$i++) {
                    if (0 === $i) {
                        $currRow = $menuStructureArr[$match[1][$i]];
                    } else {
                        $currRow = $currRow['items'][$match[1][$i]];
                    }
                    $this->output[$j] = [
                        'label' => strip_tags($currRow['label']),
                        'url' => preg_replace_callback('|.+\{id\}$|si', function($match) use ($holdUrl) { 
                            if (empty($holdUrl)) {
                                return $match[0];
                            }
                            return '/'.ltrim($holdUrl,'/'); 
                        } , $currRow['url']),
                    ];
                    if (isset($this->config['presetUrl'][$this->output[$j]['label']])) {
                        $this->output[$j]['url'] = $this->config['presetUrl'][$this->output[$j]['label']];
                    }
                    $j++;
                }
            }            
        }

        return view('widgets.breadcrumbs', [
            'config' => $this->config,
            'output' => $this->output
        ]);
    }
   
}
