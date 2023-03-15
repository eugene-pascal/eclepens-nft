<?php
declare(strict_types=1);

namespace App\Enums;

class StaticPageTypes
{
    /**
     * Get static page types
     *
     * @static
     * @return array
     */
    public static function list():array
    {
        return [
            'category' => __('Category'),
            'template' => __('Template'),
        ];
    }
}
