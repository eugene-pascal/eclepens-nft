<?php
namespace App\Classes\Theme;

class Metronic
{
    public static $attrs;
    public static $classes;

    private static $fixedHeader;

    public static function addAttr($scope, $name, $value)
    {
        self::$attrs[$scope][$name] = $value;
    }

    public static function addClass($scope, $class)
    {
        self::$classes[$scope][] = $class;
    }

    public static function printAttrs($scope)
    {
        $attrs = [];

        if (isset(self::$attrs[$scope]) && !empty(self::$attrs[$scope])) {
            foreach (self::$attrs[$scope] as $name => $value) {
                $attrs[] = $name . '="' . $value . '"';
            }
            echo ' ' . implode(' ', $attrs) . ' ';
        }
        echo '';
    }

    public static function printClasses($scope, $full = true)
    {
        if (!isset(self::$fixedHeader)||!is_bool(self::$fixedHeader)) {
            $layout_settings = app('request')->user() ? app('request')->user()->layout_settings : null;
            if (!empty($layout_settings)) {
                self::$fixedHeader = !empty($layout_settings['header']['fixed']);
            } else {
                self::$fixedHeader = config('layout.header.self.fixed.both');
            }
        }

        if ($scope == 'body') {
            self::$classes[$scope][] = 'page-loading';
            if (self::$fixedHeader) {
                if (!empty(self::$classes[$scope.'_fixed'])) {
                    self::$classes[$scope] = array_merge(self::$classes[$scope], self::$classes[$scope.'_fixed']);
                }
            } else {
                if (!empty(self::$classes[$scope.'_nofx'])) {
                    self::$classes[$scope] = array_merge(self::$classes[$scope], self::$classes[$scope.'_nofx']);
                }
            }

        }

        if ($scope == 'header') {
            if (self::$fixedHeader) {
                if (!empty(self::$classes[$scope.'_fixed'])) {
                    if (!isset(self::$classes[$scope])) {
                        self::$classes[$scope] = [];
                    }
                    self::$classes[$scope] = array_merge(self::$classes[$scope], self::$classes[$scope.'_fixed']);
                }
            }
        }

        if ($scope == 'header-mobile') {
            if (self::$fixedHeader) {
                if (!empty(self::$classes[$scope.'_fixed'])) {
                    if (!isset(self::$classes[$scope])) {
                        self::$classes[$scope] = [];
                    }
                    self::$classes[$scope] = array_merge(self::$classes[$scope], self::$classes[$scope.'_fixed']);
                }
            }
        }

        if (isset(self::$classes[$scope]) && !empty(self::$classes[$scope])) {
            $classes = implode(' ', self::$classes[$scope]);
            if ($full) {
                echo ' class="' . $classes . '" ';
            } else {
                echo ' ' . $classes . ' ';
            }
        } else {
            echo '';
        }
    }

    /**
     * Prints Google Fonts
     */
    public static function getGoogleFontsInclude()
    {
        if (config('layout.resources.fonts.google.families')) {
            $fonts = config('layout.resources.fonts.google.families');
            echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=' . implode('|', $fonts) . '">';
        }
        echo '';
    }

    /**
     * Walk recursive array with callback
     * @param array    $array
     * @param callable $callback
     * @return array
     */
    public static function arrayWalkCallback(array &$array, callable $callback)
    {
        foreach ($array as $k => &$v) {
            if (is_array($v)) {
                $callback($k, $v, $array);
                self::arrayWalkCallback($v, $callback);
            }
        }

        return $array;
    }

    /**
     * Convert css file path to RTL file
     */
    public static function rtlCssPath($css_path)
    {
        $css_path = substr_replace($css_path, '.rtl.css', -4);

        return $css_path;
    }

    /**
     * Initialize theme CSS files
     */
    public static function initThemes()
    {
        $themes = [];

        $themes[] = 'theme_assets/css/themes/layout/header/base/'.config('layout.header.self.theme').'.css';
        $themes[] = 'theme_assets/css/themes/layout/header/menu/'.config('layout.header.menu.desktop.submenu.theme').'.css';
        $themes[] = 'theme_assets/css/themes/layout/aside/'.config('layout.aside.self.theme').'.css';

        if (config('layout.aside.self.display')) {
            $themes[] = 'theme_assets/css/themes/layout/brand/'.config('layout.brand.self.theme').'.css';
        } else {
            $themes[] = 'theme_assets/css/themes/layout/brand/'.config('layout.header.self.theme').'.css';
        }

        return $themes;
    }

    /**
     * Get SVG content
     * @param string $filepath
     * @param string $class
     * @param string $addionalPathPrepand - for case if some folder neet to prepand to dafault path of svg
     *
     * @return string|string[]|null
     */
    public static function getSVG($filepath, $class = '', $addionalPathPrepand = 'theme_assets')
    {
        if (!is_string($filepath)) {
            return '';
        }

        if (!file_exists($filepath)) {
            if (empty($addionalPathPrepand) || !is_string($addionalPathPrepand) || !file_exists($addionalPathPrepand.'/'.$filepath)) {
                return '';
            }
            $filepath = $addionalPathPrepand.'/'.$filepath;
        }

        $svg_content = file_get_contents($filepath);

        $dom = new \DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new \DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $path = $dom->getElementsByTagName('path');
        foreach ($path as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');
        if (! empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        echo '<span class="'.implode(' ', $cls).'"><!--begin::Svg Icon | path:'.$filepath.'-->'.$string.'<!--end::Svg Icon--></span>';;
    }

    /**
     * Check if $path provided is SVG
     */
    public static function isSVG($path) {
        if (is_string($path)) {
            return substr(strrchr($path, '.'), 1) === 'svg';
        }

        return false;
    }
}
