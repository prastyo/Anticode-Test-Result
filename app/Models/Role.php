<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // Appending custom attributes to a model without database migrations
    protected $appends = [
        'role_badge',
    ];

    protected function roleBadge(): Attribute
    {
        // Array badge styles
        $styles = [
            'primary', 'info', 'success', 'warning', 
            'danger', 'emerald', 'cobalt', 'sunburst', 
            'crimson', 'lavender'
        ];
        $style = $styles[$this->id % count($styles)];
        return Attribute::make(
            get: fn () => '<span class="badge badge-'.$style.'">'.$this->name.'</span>'
        );
    }

    //Change the date format to make it easier for the user to understand
    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY H:mm') : null,
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY H:mm') : null,
        );
    }
}
?>