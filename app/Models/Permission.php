<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    // Appending custom attributes to a model without database migrations
    protected $appends = [
        'permission_badge',
    ];

    protected function permissionBadge(): Attribute
    {
        $permissionParts = explode('_', $this->name);
        $perm = [
            'create' => ['color' => 'primary', 'icon' => 'fas fa-plus'],
            'edit' => ['color' => 'warning', 'icon' => 'fas fa-pen'],
            'view' => ['color' => 'info', 'icon' => 'fas fa-search'],
            'delete' => ['color' => 'danger', 'icon' => 'fas fa-trash-alt'],
            'trash' => ['color' => 'dark', 'icon' => 'fas fa-close'],
        ];

        // Default value should be an array with color and icon
        $color = $perm[$permissionParts[0]] ?? ['color' => 'secondary', 'icon' => 'fas fa-question-circle'];
        array_shift($permissionParts);

        return Attribute::make(
            get: fn () => '<span class="badge badge-shadow text-'.$color['color'].' m-1"><i class="'.$color['icon'].'"></i> '.implode('_',$permissionParts).'</span>'
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