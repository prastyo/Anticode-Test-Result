<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Helpers;

class EnumStyles
{
    // This array provides predefined color codes for styling Excel cells based on enum values.
    public static function getStyles(): array
    {
        return [
            'primary'   => '6777ef',
            'info'      => '3abaf4',
            'success'   => '47c363',
            'warning'   => 'ffc107',
            'danger'    => 'fc544b',
            'cobalt'    => '005ca9',
            'lavender'  => '9c88ff',
        ];
    }
}