<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Enums;
use App\Helpers\EnumStyles;

enum IdentitasElektronikEnum: string
{
    case BELUM     = 'belum';
    case KTP_EL    = 'ktp_el';
    case KIA       = 'kia';

    /**
     * Get the label for the enum value.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            // Use a match expression to return a string label based on the current enum value ($this).
            self::BELUM     => 'Belum',
            self::KTP_EL    => 'KTP_EL',
            self::KIA       => 'KIA'
        };
    }

    public function color(): string
    {
        // Available color : 'primary', 'info', 'success', 'warning', 'danger', 'cobalt', 'lavender'
        $color = match($this) {
            self::BELUM     => 'primary',
            self::KTP_EL    => 'success',
            self::KIA       => 'danger'
        };

        return EnumStyles::getStyles()[$color];
    }

    public function badge(): string
    {
        $badgeClasses = match($this) {
            self::BELUM     => 'primary',
            self::KTP_EL    => 'success',
            self::KIA       => 'danger'
        };

        return sprintf('<span class="badge badge-%s">%s</span>', $badgeClasses, __($this->value));
    }
}