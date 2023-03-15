<?php

declare(strict_types=1);

namespace App\Enums;

class MemberTypeAccount
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
            'member' => __('Member'),
//            'partner' => __('Partner'),
        ];
    }
}