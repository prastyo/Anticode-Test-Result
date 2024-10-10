<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasUserStamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DataCacat extends Model
{
    /** @use HasFactory<\Database\Factories\DataCacatFactory> */
    use HasFactory; // To enable model factories for creating model instances easily during testing or seeding.
    use SoftDeletes; // allows you to 'mark' data as deleted without permanently removing it from the database
    use HasUserStamp; // Automatically sets created_by and updated_by fields based on the authenticated user during model creation and updates

    /**
     * The table associated with the model.
     * By default, Laravel assumes the table name is the plural form of the model's class name.
     */
    protected $table    = 'data_cacat';

    /**
     * The attributes that are eligible for mass assignment without explicitly 
     * defining request or database column names (e.g., during `create()` or `update()` operations).
     */
    protected $fillable = [
                            'nama'
                        ];

    /**
     * Define a belongsTo relationship between the current model and the related model.
     * This indicates that the current model holds the foreign key of the related model.
     */

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleted_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * Define a hasMany relationship between the current model and the related model.
     * This indicates that the current model can have multiple instances of the related model.
     */

    public function penduduk(): hasMany
    {
        return $this->hasMany(Penduduk::class, 'cacat_id');
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

    // deleted_at serves as an indicator that the record has been temporarily removed from the database
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY H:mm') : null,
        );
    }
}