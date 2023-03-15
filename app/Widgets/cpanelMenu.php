<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class cpanelMenu extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * compiled HTML code
     *
     * @var string
     */
    protected $output = '';

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $items = $this->normalizeItems($this->config['items'], $hasActiveChild);

        if (!empty($items)) {
            $tag = !empty($this->config['tag']) ? $this->config['tag'] : 'ul' ;
            $output = '<'.$tag;
            if (!empty($this->config['options'])) {
                $output.=' ';
                foreach ($this->config['options'] as $key => $value) {
                   $output.="$key=\"$value\" ";
                }
                $output = rtrim($output, ' ');
            }
            $output.='>'. $this->renderItems($items) .'</'.$tag.'>';
        }
        return view('widgets.cpanel_menu', [
            'output' => $output,
            'config' => $this->config,
        ]);
    }
    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @return string the rendering result
     */
    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options =  array_get($item, 'options');
            $class = [];
            if ($item['active'] && isset($this->config['activeCssClass'])) {
                $class[] = $this->config['activeCssClass'];
            }
            if ($i === 0 && !empty($this->config['firstItemCssClass'])) {
                $class[] = $this->config['firstItemCssClass'];
            }
            if ($i === $n - 1 && !empty($this->config['lastItemCssClass'])) {
                $class[] = $this->config['lastItemCssClass'];
            }

            if (!empty($options['class']) && !empty($class)) {
                $options['class'].=' '.implode(' ',$class);
            } else 
            if (!isset($options['class']) && !empty($class)) {
                $options['class'] = implode(' ',$class);
            }
            $optionsInString = '';
            if (!empty($options)) {
                foreach ($options as $key => $value) {
                   $optionsInString.="$key=\"$value\" ";
                }
                $optionsInString = ' '.trim($optionsInString, ' ');
            }

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = $this->config['submenuTemplate'];
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }

            $tag = array_get($item, 'tag', 'li');
            $lines[] = '<'.$tag.$optionsInString.'>'. $menu. '</'.$tag.'>';
        }
        return implode("\n", $lines);

    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = array_get($item, 'template', '<a href="{url}">{label}</a>');
            // @todo hardcode to replace arrow state
            if ($item['active'] && preg_match('|\"arrow\"|si', $template)) {
                $template = str_replace("\"arrow\"", "\"arrow open\"", $template);
            }
            return strtr($template, [
                '{url}' => $item['url'],
                '{label}' => $item['label'],
            ]);
        }
        $template =  array_get($item, 'labelTemplate', '{label}');
        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

    /**
     * Normalizes the [[items]] property to remove invisible items and activate certain items.
     * @param array $items the items to be normalized.
     * @param bool $active whether there is an active child menu item.
     * @return array the normalized menu items
     */
    protected function normalizeItems($items, &$active)
    {
        foreach ($items as $i => $item) {
            if (isset($item['visible']) && !$item['visible']) {
                unset($items[$i]);
                continue;
            }
            $hasActiveChild = false;
            if (!isset($item['label'])) {
                $item['label'] = '';
            }
            if (isset($item['items'])) {
                $items[$i]['items'] = $this->normalizeItems($item['items'], $hasActiveChild);
            }
            if (!isset($item['active'])) {
                if ($this->isItemActive($item) || (isset($this->config['activateParents']) && $this->config['activateParents'] && $hasActiveChild)) {
                    $active = $items[$i]['active'] = true;
                } else {
                    $items[$i]['active'] = false;
                }
            } elseif ($item['active']) {
                $active = true;
            }
        }
        return array_values($items);
    }


    /**
     * Checks whether a menu item is active.
     * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
     * When the `url` option of a menu item is specified in terms of an array, its first element is treated
     * as the route for the item and the rest of the elements are the associated parameters.
     * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
     * be considered active.
     * @param array $item the menu item to be checked
     * @return bool whether the menu item is active
     */
    protected function isItemActive($item)
    {
        if (isset($item['url']) && is_string($item['url'])) {
            $currUrl = trim($item['url'],'/');
            if (preg_match('|^https?\:\/\/|i', $currUrl)) {
                $route = trim(\Request::url(),'/');
            } else {
                $route = trim(\Request::path(),'/');
            }
            return ($currUrl === $route);
        }
        return false;
    }
}
