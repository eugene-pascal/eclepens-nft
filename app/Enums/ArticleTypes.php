<?php

declare(strict_types=1);

namespace App\Enums;

class ArticleTypes
{
    /**
     * Get list languages
     *
     * @static
     * @return array
     */
    public static function langList():array
    {
        return [
            'en' => __('English'),
            'fr' => __('Français'),
            'de' => __('Deutsch'),
            'es' => __('Español'),
            'pt' => __('Português'),
            'it' => __('Italiano'),
            'gr' => __('Ελληνική'),
        ];
    }
}