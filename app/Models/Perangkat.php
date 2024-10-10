<?php
/**
 * Budi Prastyo <budi@prastyo.com>
 * created_at : 2024-10-10 17:36:07
 */

namespace App\Models;

use Carbon\Carbon;
use App\Traits\HasUserStamp;
use App\Enums\StatusPejabatEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Perangkat extends Model
{
    /** @use HasFactory<\Database\Factories\PerangkatFactory> */
    use HasFactory; // To enable model factories for creating model instances easily during testing or seeding.
    use SoftDeletes; // allows you to 'mark' data as deleted without permanently removing it from the database
    use HasUserStamp; // Automatically sets created_by and updated_by fields based on the authenticated user during model creation and updates

    /**
     * The table associated with the model.
     * By default, Laravel assumes the table name is the plural form of the model's class name.
     */
    protected $table    = 'perangkat';

    /**
     * The attributes that are eligible for mass assignment without explicitly 
     * defining request or database column names (e.g., during `create()` or `update()` operations).
     */
    protected $fillable = [
                            'nip',
                            'nipd',
                            'jabatan_id',
                            'penduduk_id',
                            'masa_jabatan',
                            'status_pejabat',
                            'pangkat_golongan',
                            'no_keputusan_pengangkatan',
                            'no_keputusan_pemberhentian',
                            'tanggal_keputusan_pengangkatan',
                            'tanggal_keputusan_pemberhentian'
                        ];

    // Defines how attributes should be converted when retrieving or setting data
    protected function casts(): array
    {
        return [
                'tanggal_keputusan_pengangkatan'     => 'date',
                'tanggal_keputusan_pemberhentian'    => 'date',
                'status_pejabat'                     => StatusPejabatEnum::class
            ];
    }

    /**
     * Define a belongsTo relationship between the current model and the related model.
     * This indicates that the current model holds the foreign key of the related model.
     */

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class, 'penduduk_id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(DataJabatan::class, 'jabatan_id');
    }

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

    // Mutator Accessor to change date format when data is retrieved and edited
    protected function tanggalKeputusanPengangkatan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY') : null, //to display the day, full month name, and year (e.g., "5 September 2024")
            set: fn ($value) => $value ? Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null // Store in the database using the Y-m-d format
        );
    }

    // Mutator Accessor to change date format when data is retrieved and edited
    protected function tanggalKeputusanPemberhentian(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY') : null, //to display the day, full month name, and year (e.g., "5 September 2024")
            set: fn ($value) => $value ? Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d') : null // Store in the database using the Y-m-d format
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

    // deleted_at serves as an indicator that the record has been temporarily removed from the database
    protected function deletedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->locale(app()->getLocale())->isoFormat('D MMMM YYYY H:mm') : null,
        );
    }
}