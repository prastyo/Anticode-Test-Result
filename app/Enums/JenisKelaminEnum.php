<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Enums;
use App\Helpers\EnumStyles;

enum JenisKelaminEnum: string
{
    case LAKI_LAKI    = 'laki_laki';
    case PEREMPUAN    = 'perempuan';

    /**
     * Get the label for the enum value.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            // Use a match expression to return a string label based on the current enum value ($this).
            self::LAKI_LAKI    => 'Laki-laki',
            self::PEREMPUAN    => 'Perempuan'
        };
    }

    public function color(): string
    {
        // Available color : 'primary', 'info', 'success', 'warning', 'danger', 'cobalt', 'lavender'
        $color = match($this) {
            self::LAKI_LAKI    => 'info',
            self::PEREMPUAN    => 'cobalt'
        };

        return EnumStyles::getStyles()[$color];
    }

    public function badge(): string
    {
        $badgeClasses = match($this) {
            self::LAKI_LAKI    => 'info',
            self::PEREMPUAN    => 'cobalt'
        };

        return sprintf('<span class="badge badge-%s">%s</span>', $badgeClasses, __($this->value));
    }
}