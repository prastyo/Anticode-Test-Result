<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Enums;
use App\Helpers\EnumStyles;

enum JenisKeuanganEnum: string
{
    case PENDAPATAN    = 'pendapatan';
    case PEMBIAYAAN    = 'pembiayaan';

    /**
     * Get the label for the enum value.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            // Use a match expression to return a string label based on the current enum value ($this).
            self::PENDAPATAN    => 'Pendapatan',
            self::PEMBIAYAAN    => 'Pembiayaan'
        };
    }

    public function color(): string
    {
        // Available color : 'primary', 'info', 'success', 'warning', 'danger', 'cobalt', 'lavender'
        $color = match($this) {
            self::PENDAPATAN    => 'lavender',
            self::PEMBIAYAAN    => 'warning'
        };

        return EnumStyles::getStyles()[$color];
    }

    public function badge(): string
    {
        $badgeClasses = match($this) {
            self::PENDAPATAN    => 'lavender',
            self::PEMBIAYAAN    => 'warning'
        };

        return sprintf('<span class="badge badge-%s">%s</span>', $badgeClasses, __($this->value));
    }
}