<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Traits;

//use Illuminate\Database\Eloquent\Model;

trait HasUserStamp
{
    protected static function bootHasUserStamp()
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });

        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && !$model->isForceDeleting()) {

                $model->deleted_by = auth()->id();

                // Temporarily disable timestamps
                $model->timestamps = false;

                // Save the model without triggering events and without modifying the updated_at timestamp.
                $model->saveQuietly();
            }
        });
    }
}
?>