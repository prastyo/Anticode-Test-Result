<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Enums;
use App\Helpers\EnumStyles;

enum AkteKelahiranEnum: string
{
    case ADA          = 'ada';
    case TIDAK_ADA    = 'tidak_ada';

    /**
     * Get the label for the enum value.
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            // Use a match expression to return a string label based on the current enum value ($this).
            self::ADA          => 'Ada',
            self::TIDAK_ADA    => 'Tidak Ada'
        };
    }

    public function color(): string
    {
        // Available color : 'primary', 'info', 'success', 'warning', 'danger', 'cobalt', 'lavender'
        $color = match($this) {
            self::ADA          => 'lavender',
            self::TIDAK_ADA    => 'warning'
        };

        return EnumStyles::getStyles()[$color];
    }

    public function badge(): string
    {
        $badgeClasses = match($this) {
            self::ADA          => 'lavender',
            self::TIDAK_ADA    => 'warning'
        };

        return sprintf('<span class="badge badge-%s">%s</span>', $badgeClasses, __($this->value));
    }
}